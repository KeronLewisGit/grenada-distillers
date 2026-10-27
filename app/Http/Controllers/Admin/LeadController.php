<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadFile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** The unified inbox: every web request the signed-in role works, new first. */
class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $user = $this->user($request);
        $filters = $this->filters($request, $user);
        $base = Lead::visibleTo($user);

        $counts = (clone $base)->filter(array_merge($filters, ['status' => null]))
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.leads.index', [
            'leads' => (clone $base)->with(['jobPosting', 'assignee'])->filter($filters)->inboxOrder()
                ->paginate(25)->withQueryString(),
            'filters' => $filters,
            'counts' => $counts,
            'types' => $user->role->leadTypes(),
            'staff' => User::active()->orderBy('name')->get(['id', 'name', 'role']),
        ]);
    }

    public function show(Request $request, Lead $lead): View
    {
        Gate::authorize('view', $lead);
        $lead->load(['jobPosting', 'assignee', 'notes.user', 'files']);
        $user = $this->user($request);
        // Previous / next in the same order as the inbox: new leads first, then newest first.
        $ids = Lead::visibleTo($user)->inboxOrder()->pluck('id');
        $pos = $ids->search($lead->id);

        return view('admin.leads.show', [
            'lead' => $lead,
            'staff' => User::active()->orderBy('name')->get(['id', 'name', 'role'])
                ->filter(fn (User $u) => $u->canWork($lead->type))->values(),
            'neighbours' => [
                'prev' => $pos !== false ? $ids->get($pos - 1) : null,
                'next' => $pos !== false ? $ids->get($pos + 1) : null,
            ],
        ]);
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('update', $lead);
        $user = $this->user($request);
        $data = $request->validate([
            'status' => ['sometimes', Rule::enum(LeadStatus::class)],
            'assigned_to' => ['sometimes', 'nullable', 'integer', Rule::exists('users', 'id')->where('active', true)],
        ]);

        if (isset($data['status'])) {
            $status = LeadStatus::from($data['status']);
            if (! in_array($status, $lead->type->statuses(), true)) {
                return back()->withErrors(['status' => "{$status->label()} is not a status for a {$lead->type->label()}."]);
            }
        }
        if (isset($status) && $lead->moveTo($status)) {
            $lead->notes()->create(['user_id' => $user->id, 'kind' => 'status', 'body' => 'Status changed to '.$status->label().'.']);
        }
        // The form posts the id as a string; compare as integers so an unchanged choice adds no note.
        $assignTo = isset($data['assigned_to']) ? (int) $data['assigned_to'] : null;
        if (array_key_exists('assigned_to', $data) && $lead->assigned_to !== $assignTo) {
            $assignee = $assignTo ? User::find($assignTo) : null;
            if ($assignee && ! $assignee->canWork($lead->type)) {
                return back()->withErrors(['assigned_to' => "{$assignee->name} works in {$assignee->role->label()} and can't see this request."]);
            }
            $lead->assigned_to = $assignee?->id;
            $lead->notes()->create(['user_id' => $user->id, 'kind' => 'assign', 'body' => $assignee ? "Assigned to {$assignee->name}." : 'Unassigned.']);
        }
        $lead->save();

        return back()->with('status', "{$lead->reference} saved.");
    }

    public function note(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('update', $lead);
        $data = $request->validate(['body' => ['required', 'string', 'max:3000'], 'contacted' => ['nullable', 'boolean']]);
        $user = $this->user($request);

        $lead->notes()->create(['user_id' => $user->id, 'kind' => 'note', 'body' => $data['body']]);
        // Logging a reply on a new request counts as the first response.
        if (! empty($data['contacted']) && $lead->status === LeadStatus::New) {
            $next = $lead->type->firstReplyStatus();
            $lead->moveTo($next);
            $lead->notes()->create(['user_id' => $user->id, 'kind' => 'status', 'body' => 'Status changed to '.$next->label().'.']);
        }
        $lead->first_contacted_at ??= ! empty($data['contacted']) ? now() : null;
        $lead->save();

        return back()->with('status', 'Note added.')->withFragment('timeline');
    }

    /** Uploads stream from the private disk. CVs: HR and administrators only, and each opening is logged. */
    public function file(Request $request, Lead $lead, LeadFile $file): StreamedResponse
    {
        Gate::authorize('openFile', [$lead, $file]);
        abort_unless(Storage::disk('local')->exists($file->path), 404);

        $lead->notes()->create(['user_id' => $this->user($request)->id, 'kind' => 'system', 'body' => "Opened {$file->label()} ({$file->original_name})."]);
        $name = Str::slug($lead->reference.'-'.$file->label()).'.'.pathinfo($file->path, PATHINFO_EXTENSION);

        return $file->isImage() && ! $request->boolean('download')
            ? Storage::disk('local')->response($file->path, $name, ['Cache-Control' => 'private, no-store'])
            : Storage::disk('local')->download($file->path, $name, ['Cache-Control' => 'private, no-store']);
    }

    public function export(Request $request): StreamedResponse
    {
        $user = $this->user($request);
        $query = Lead::visibleTo($user)->with(['jobPosting', 'assignee'])->filter($this->filters($request, $user));

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // byte-order mark so Excel reads accents correctly
            fputcsv($out, ['Reference', 'Received', 'Type', 'Status', 'Name', 'Organisation', 'Country', 'Phone', 'Email', 'Prefers', 'About', 'Tour', 'Guests', 'Assigned to', 'First reply', 'Minutes to first reply'], escape: '');
            foreach ($query->lazyByIdDesc(500) as $l) {
                /** @var Lead $l */
                fputcsv($out, array_map(self::csvSafe(...), [
                    $l->reference, $l->created_at->format('Y-m-d H:i'), $l->type->label(), $l->status->label(), $l->name,
                    $l->organisation, $l->country, format_phone($l->phone), $l->email, $l->contact_pref, $l->subject(),
                    $l->visit_date ? $l->visit_date->format('Y-m-d').' '.$l->visit_time : '', $l->guests,
                    $l->assignee->name ?? '', $l->first_contacted_at?->format('Y-m-d H:i'),
                    $l->first_contacted_at ? (string) (int) $l->created_at->diffInMinutes($l->first_contacted_at) : '',
                ]), escape: '');
            }
            fclose($out);
        }, 'clarkes-court-requests-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** Customer-typed text starting with = + - @ would run as a formula in Excel, so it gets a leading quote. */
    private static function csvSafe(mixed $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+\-@\t\r]/', $value) ? "'".$value : $value;
    }

    /** @return array<string, string|null> */
    private function filters(Request $request, User $user): array
    {
        $type = LeadType::tryFrom(input_string($request->query('type')));
        $statusIn = input_string($request->query('status'));
        $assigned = input_string($request->query('assigned'));

        return [
            'type' => $type && $user->canWork($type) ? $type->value : null,
            'status' => $statusIn === 'open' ? 'open' : LeadStatus::tryFrom($statusIn)?->value,
            'assigned' => match (true) {
                $assigned === 'me' => (string) $user->id,
                $assigned === 'none', ctype_digit($assigned) => $assigned,
                default => null,
            },
            'overdue' => $request->boolean('overdue') ? '1' : null,
            'q' => input_string($request->query('q')) ?: null,
        ];
    }

    private function user(Request $request): User
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        return $user;
    }
}

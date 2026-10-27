@php
    /** @var \App\Models\Lead $lead */
    use App\Enums\LeadType;
    $d = $lead->details ?? [];
    $rows = match ($lead->type) {
        LeadType::Tour => [
            'Tour' => $lead->visit_date ? $lead->visit_date->format('l j F Y').' at '.\App\Support\Tours::label((string) $lead->visit_time) : null,
            'Adults (18+)' => $d['adults'] ?? null,
            'Under 18' => $d['children'] ?? null,
            'Party' => gdl('tours.group_types.'.($d['group_type'] ?? '')),
            'Staying at' => $d['staying'] ?? null,
            'Visiting from' => $lead->country,
            'Access needs' => $d['access'] ?? null,
        ],
        LeadType::Trade => [
            'Company' => $lead->organisation,
            'Job title' => $d['job_title'] ?? null,
            'Country' => $lead->country,
            'Business' => gdl('trade.business_types.'.($d['business_type'] ?? '')),
            'Markets' => $d['markets'] ?? null,
            'Interested in' => $lead->productNames() ?: 'Not specified',
            'First order' => gdl('trade.volumes.'.($d['volume'] ?? '')),
            'Import licence' => ['yes' => 'Yes', 'in_progress' => 'Applying', 'no' => 'No'][$d['licensed'] ?? ''] ?? null,
            'Website' => $d['company_site'] ?? null,
        ],
        LeadType::Application => [
            'Vacancy' => $lead->jobPosting->title ?? 'General application',
            'Parish' => gdl('parishes.'.($d['parish'] ?? '')),
            'Experience' => gdl('careers.experience.'.($d['experience'] ?? '')),
            'Highest qualification' => gdl('careers.qualifications.'.($d['qualification'] ?? '')),
            'Current or last job' => $d['current_role'] ?? null,
            'Can start' => isset($d['available_from']) ? \Illuminate\Support\Carbon::parse($d['available_from'])->format('j M Y') : 'Not stated',
            'Consent to keep for 12 months' => $lead->consented_at?->format('j M Y H:i'),
        ],
        LeadType::Enquiry => [
            'Topic' => gdl('enquiry_topics.'.($d['topic'] ?? '')),
            'Country' => $lead->country,
        ],
    };
    $replyLabel = match ($lead->type) {
        LeadType::Tour => 'I confirmed the booking with the guest',
        LeadType::Application => 'I acknowledged the application',
        default => 'I replied to them',
    };
    $waText = 'Hello '.strtok($lead->name, ' ').", this is Clarke's Court about your ".strtolower($lead->type->label()).' ('.$lead->reference.').';
@endphp
<x-layouts.admin :title="$lead->name">
    <x-slot:actions>
        @if ($neighbours['prev'])<a href="{{ route('admin.leads.show', $neighbours['prev']) }}" class="a-btn a-btn-ghost w-11 px-0" aria-label="Previous request in the inbox"><x-icon name="chevron-left" class="h-4 w-4" /></a>@endif
        @if ($neighbours['next'])<a href="{{ route('admin.leads.show', $neighbours['next']) }}" class="a-btn a-btn-ghost w-11 px-0" aria-label="Next request in the inbox"><x-icon name="chevron-right" class="h-4 w-4" /></a>@endif
        <a href="{{ route('admin.leads.index') }}" class="a-btn a-btn-ghost">Back to inbox</a>
    </x-slot:actions>

    <div class="flex flex-wrap items-center gap-2 text-sm">
        <span class="chip num" data-tone="neutral"><x-icon :name="$lead->type->icon()" />{{ $lead->type->label() }} · {{ $lead->reference }}</span>
        <x-status :status="$lead->status" />
        @if ($lead->isOverdue())<span class="chip" data-tone="critical"><x-icon name="clock" />Waiting {{ $lead->created_at->diffForHumans(null, true) }}</span>@endif
        <span class="text-ink-3">Received {{ $lead->created_at->format('D j M Y, H:i') }}</span>
    </div>

    <div class="mt-5 grid gap-6 xl:grid-cols-[1.4fr_1fr]">
        <div class="min-w-0 space-y-6">
            <section class="a-card p-5" aria-labelledby="contact-title">
                <h2 id="contact-title" class="font-semibold">Contact</h2>
                <div class="mt-3 grid gap-4 sm:grid-cols-2">
                    <div class="min-w-0">
                        <p class="break-words text-lg font-semibold">{{ $lead->email }}</p>
                        @if ($lead->phone)<p class="num text-ink-2">{{ format_phone($lead->phone) }}</p>@endif
                        <p class="mt-1 text-sm text-ink-3">Prefers {{ ['phone' => 'a phone call', 'whatsapp' => 'WhatsApp', 'email' => 'email'][$lead->contact_pref] ?? $lead->contact_pref }}</p>
                    </div>
                    <div class="flex flex-wrap content-start gap-2">
                        <a href="mailto:{{ $lead->email }}?subject={{ rawurlencode("Clarke's Court: ".$lead->reference) }}" class="a-btn a-btn-primary"><x-icon name="mail" class="h-4 w-4" />Email</a>
                        @if ($lead->phone)
                            <a href="{{ tel_href($lead->phone) }}" class="a-btn a-btn-ghost"><x-icon name="phone" class="h-4 w-4" />Call</a>
                            <a href="{{ wa_href($lead->phone, $waText) }}" class="a-btn a-btn-ghost" target="_blank" rel="noopener"><x-icon name="whatsapp" class="h-4 w-4" />WhatsApp</a>
                        @endif
                    </div>
                </div>
            </section>

            <section class="a-card p-5" aria-labelledby="req-title">
                <h2 id="req-title" class="font-semibold">{{ $lead->type->label() }}</h2>
                <x-spec class="mt-3 max-w-xl" :rows="$rows" />
                @if ($lead->message)
                    <blockquote class="mt-4 whitespace-pre-line rounded-lg bg-surface-2 p-4">{{ $lead->message }}</blockquote>
                @endif
                @if ($lead->source_url)<p class="mt-3 truncate text-xs text-ink-3">From {{ $lead->source_url }}</p>@endif
            </section>

            @if ($lead->files->isNotEmpty())
                <section class="a-card p-5" aria-labelledby="files-title">
                    <h2 id="files-title" class="font-semibold">Uploads</h2>
                    <ul class="mt-3 divide-y divide-line">
                        @foreach ($lead->files as $f)
                            <li class="flex flex-wrap items-center gap-3 py-3">
                                <x-icon :name="$f->isImage() ? 'image' : 'file'" class="h-5 w-5 text-ink-3" />
                                <div class="min-w-0 flex-1"><p class="font-semibold">{{ $f->label() }}</p><p class="truncate text-sm text-ink-3">{{ $f->original_name }} · {{ number_format($f->size / 1024) }} KB</p></div>
                                @can('openFile', [$lead, $f])
                                    <a href="{{ route('admin.leads.file', [$lead, $f]) }}" class="a-btn a-btn-ghost"><x-icon name="download" class="h-4 w-4" />Download</a>
                                @else
                                    <span class="chip" data-tone="muted"><x-icon name="lock" />HR only</span>
                                @endcan
                            </li>
                        @endforeach
                    </ul>
                    @if ($lead->type === LeadType::Application)<p class="mt-2 text-sm text-ink-3">Every download is recorded on the timeline.</p>@endif
                </section>
            @endif
        </div>

        <div class="min-w-0 space-y-6">
            <section class="a-card p-5" aria-labelledby="manage-title">
                <h2 id="manage-title" class="font-semibold">Manage</h2>
                <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="mt-3 space-y-4">
                    @csrf @method('PATCH')
                    <div><label for="status" class="mb-1 block text-sm font-semibold">Status</label>
                        <select id="status" name="status" class="a-input w-full">@foreach ($lead->type->statuses() as $s)<option value="{{ $s->value }}" @selected($lead->status === $s)>{{ $s->label() }}</option>@endforeach</select>
                        @if ($lead->type === LeadType::Tour)<p class="mt-1 text-xs text-ink-3">Cancelling frees the guests' places for others.</p>@endif
                    </div>
                    <div><label for="assigned_to" class="mb-1 block text-sm font-semibold">Assigned to</label>
                        <select id="assigned_to" name="assigned_to" class="a-input w-full"><option value="">Nobody</option>@foreach ($staff as $u)<option value="{{ $u->id }}" @selected($lead->assigned_to === $u->id)>{{ $u->name }} ({{ $u->role->label() }})</option>@endforeach</select></div>
                    <button class="a-btn a-btn-primary w-full">Save</button>
                </form>
            </section>

            <section id="timeline" class="a-card p-5" aria-labelledby="tl-title">
                <h2 id="tl-title" class="font-semibold">Timeline</h2>
                <form method="POST" action="{{ route('admin.leads.note', $lead) }}" class="mt-3 space-y-2">
                    @csrf
                    <label for="body" class="sr-only">Add a note</label>
                    <textarea id="body" name="body" rows="3" class="a-input w-full" placeholder="Emailed, called, sent samples…" required maxlength="3000"></textarea>
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        @if ($lead->status === \App\Enums\LeadStatus::New)
                            <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="contacted" value="1" class="h-5 w-5" checked>{{ $replyLabel }}</label>
                        @endif
                        <button class="a-btn a-btn-primary ml-auto">Add note</button>
                    </div>
                </form>
                <ol class="mt-5 space-y-4 border-l-2 border-line pl-5">
                    @foreach ($lead->notes as $n)
                        <li class="relative">
                            <span @class(['absolute -left-[1.6rem] top-1.5 h-2.5 w-2.5 rounded-full', 'bg-accent' => $n->kind === 'note', 'bg-[color:var(--series-1)]' => in_array($n->kind, ['status', 'assign'], true), 'bg-line-strong' => $n->kind === 'system']) aria-hidden="true"></span>
                            <p @class(['whitespace-pre-line break-words', 'text-ink-2' => $n->kind !== 'note'])>{{ $n->body }}</p>
                            <p class="mt-0.5 text-xs text-ink-3">{{ $n->user->name ?? 'Website' }} · {{ $n->created_at->format('j M, H:i') }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>
    </div>
</x-layouts.admin>

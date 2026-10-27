<?php

namespace App\Support;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Models\Lead;
use App\Notifications\LeadReceived;
use App\Notifications\NewLead;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Every public form ends here: one lead row with a reference, any upload on the private
 * disk, a first timeline entry, an email to the right office and a confirmation to the sender.
 */
final class LeadIntake
{
    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<string, list<UploadedFile|array{path: string, name: string, mime: string|null, size: int}>>  $files  kind => files (an array is a PendingUpload kept from an earlier attempt)
     */
    public static function create(LeadType $type, array $attributes, array $files, Request $request): Lead
    {
        $lead = Lead::create($attributes + [
            'type' => $type,
            'status' => LeadStatus::New,
            'source_url' => mb_substr((string) $request->headers->get('referer', $request->fullUrl()), 0, 300),
        ]);

        foreach ($files as $kind => $list) {
            foreach ($list as $file) {
                if (is_array($file)) {
                    $path = 'leads/'.$lead->id.'/'.basename($file['path']);
                    Storage::disk('local')->move($file['path'], $path);
                    Storage::disk('local')->deleteDirectory(dirname($file['path']));
                    $lead->files()->create(['kind' => $kind, 'path' => $path, 'original_name' => $file['name'], 'mime' => $file['mime'], 'size' => $file['size']]);

                    continue;
                }
                $lead->files()->create([
                    'kind' => $kind,
                    // Random file name, private disk, one folder per lead.
                    'path' => $file->store('leads/'.$lead->id, 'local'),
                    'original_name' => mb_substr($file->getClientOriginalName(), 0, 200),
                    'mime' => $file->getMimeType(),
                    'size' => (int) $file->getSize(),
                ]);
            }
        }

        $lead->notes()->create(['kind' => 'system', 'body' => 'Received from the website'.($lead->subject() ? ': '.$lead->subject() : '').'.']);

        Notify::office(new NewLead($lead), $type);
        Notify::customer($lead->email, new LeadReceived($lead));

        // Kept (not flashed) so refreshing the thank-you page still shows the number.
        $request->session()->put('last_lead', ['reference' => $lead->reference, 'type' => $type->value]);

        return $lead;
    }

    /** Bots fill the hidden "website" field. Pretend it worked and keep nothing. */
    public static function isBot(Request $request, LeadType $type): bool
    {
        if ($request->filled('website')) {
            $request->session()->put('last_lead', ['reference' => $type->prefix().'-'.now()->format('y').'-00000', 'type' => $type->value]);

            return true;
        }

        return false;
    }
}

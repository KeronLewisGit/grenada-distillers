<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A valid upload kept while the rest of its form comes back with errors, so a job applicant does
 * not have to attach the CV again. Files sit on the private disk under pending/, and only the
 * visitor's own session knows the path. Anything older than a day is deleted on the next upload.
 */
final class PendingUpload
{
    private const string DIR = 'pending';

    private const int KEEP_HOURS = 24;

    public static function stash(Request $request, string $field, UploadedFile $file): void
    {
        self::prune();
        self::forget($request, $field);
        $path = $file->store(self::DIR.'/'.Str::random(32), 'local');
        if ($path === false) {
            return;
        }
        $request->session()->put(self::key($field), [
            'path' => $path,
            'name' => mb_substr($file->getClientOriginalName(), 0, 200),
            'mime' => $file->getMimeType(),
            'size' => (int) $file->getSize(),
        ]);
    }

    /** @return array{path: string, name: string, mime: string|null, size: int}|null */
    public static function get(Request $request, string $field): ?array
    {
        $pending = $request->session()->get(self::key($field));
        if (! is_array($pending) || ! is_string($pending['path'] ?? null) || ! str_starts_with($pending['path'], self::DIR.'/')
            || ! Storage::disk('local')->exists($pending['path'])) {
            return null;
        }

        return [
            'path' => $pending['path'],
            'name' => (string) ($pending['name'] ?? 'file'),
            'mime' => isset($pending['mime']) ? (string) $pending['mime'] : null,
            'size' => (int) ($pending['size'] ?? 0),
        ];
    }

    /**
     * Hands the file over (the caller moves it); the session forgets it.
     *
     * @return array{path: string, name: string, mime: string|null, size: int}|null
     */
    public static function take(Request $request, string $field): ?array
    {
        $pending = self::get($request, $field);
        $request->session()->forget(self::key($field));

        return $pending;
    }

    public static function forget(Request $request, string $field): void
    {
        $pending = self::get($request, $field);
        if ($pending) {
            Storage::disk('local')->deleteDirectory(dirname($pending['path']));
        }
        $request->session()->forget(self::key($field));
    }

    /** Deletes pending uploads nobody came back for. */
    public static function prune(): void
    {
        $disk = Storage::disk('local');
        $cutoff = now()->subHours(self::KEEP_HOURS)->getTimestamp();
        foreach ($disk->directories(self::DIR) as $dir) {
            $files = $disk->files($dir);
            if ($files === [] || max(array_map(fn (string $f) => $disk->lastModified($f), $files)) < $cutoff) {
                $disk->deleteDirectory($dir);
            }
        }
    }

    private static function key(string $field): string
    {
        return 'pending_upload.'.$field;
    }
}

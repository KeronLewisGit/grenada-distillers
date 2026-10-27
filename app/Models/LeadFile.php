<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Uploads (CVs). Always on the private "local" disk, streamed only to staff the policy allows.
 *
 * @property int $id
 * @property int $lead_id
 * @property string $kind
 * @property string $path
 * @property string $original_name
 * @property string|null $mime
 * @property int $size
 * @property-read Lead $lead
 */
class LeadFile extends Model
{
    /** Kinds only HR and administrators may open. */
    public const array HR_KINDS = ['cv'];

    protected $fillable = ['lead_id', 'kind', 'path', 'original_name', 'mime', 'size'];

    /** @return BelongsTo<Lead, $this> */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function isHrDocument(): bool
    {
        return in_array($this->kind, self::HR_KINDS, true);
    }

    public function isImage(): bool
    {
        return str_starts_with((string) $this->mime, 'image/');
    }

    public function label(): string
    {
        return match ($this->kind) {
            'cv' => 'CV',
            default => 'File',
        };
    }
}

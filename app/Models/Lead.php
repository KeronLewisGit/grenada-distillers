<?php

namespace App\Models;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Support\Rums;
use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * One web request: a tour booking, a trade enquiry, a job application or a message.
 *
 * @property int $id
 * @property string $reference
 * @property LeadType $type
 * @property LeadStatus $status
 * @property string $name
 * @property string|null $phone
 * @property string $email
 * @property string $contact_pref
 * @property string|null $country
 * @property string|null $organisation
 * @property int|null $job_posting_id
 * @property int|null $assigned_to
 * @property Carbon|null $visit_date
 * @property string|null $visit_time
 * @property int|null $guests
 * @property array<string, mixed>|null $details
 * @property string|null $message
 * @property Carbon|null $consented_at
 * @property string|null $source_url
 * @property Carbon|null $first_contacted_at
 * @property Carbon|null $status_changed_at
 * @property Carbon $created_at
 * @property-read JobPosting|null $jobPosting
 * @property-read User|null $assignee
 * @property-read Collection<int, LeadNote> $notes
 * @property-read Collection<int, LeadFile> $files
 */
class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    /** A new request nobody has answered within this many hours is overdue (one working day). */
    public const int RESPONSE_HOURS = 24;

    protected $fillable = [
        'type', 'status', 'name', 'phone', 'email', 'contact_pref', 'country', 'organisation', 'job_posting_id', 'assigned_to',
        'visit_date', 'visit_time', 'guests', 'details', 'message', 'consented_at', 'source_url',
        'first_contacted_at', 'status_changed_at',
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
            'type' => LeadType::class,
            'status' => LeadStatus::class,
            'details' => 'array',
            'visit_date' => 'date',
            'guests' => 'integer',
            'consented_at' => 'datetime',
            'first_contacted_at' => 'datetime',
            'status_changed_at' => 'datetime',
        ];
    }

    #[\Override]
    protected static function booted(): void
    {
        static::creating(function (self $lead): void {
            $lead->reference ??= 'pending-'.bin2hex(random_bytes(4));
            $lead->status ??= LeadStatus::New;
        });
        static::created(function (self $lead): void {
            $lead->forceFill([
                'reference' => sprintf('%s-%s-%05d', $lead->type->prefix(), $lead->created_at->format('y'), $lead->id),
            ])->saveQuietly();
        });
        static::saving(function (self $lead): void {
            $lead->phone_digits = preg_replace('/\D+/', '', (string) $lead->phone) ?: null;
        });
    }

    /** @return BelongsTo<JobPosting, $this> */
    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }

    /** @return BelongsTo<User, $this> */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** @return HasMany<LeadNote, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class)->latest('id');
    }

    /** @return HasMany<LeadFile, $this> */
    public function files(): HasMany
    {
        return $this->hasMany(LeadFile::class);
    }

    /** A one-line "what about": the tour slot, the trade partner, the vacancy or the topic. */
    public function subject(): ?string
    {
        return match ($this->type) {
            LeadType::Tour => $this->visit_date ? $this->visit_date->format('D j M').' '.$this->visit_time.' · '.$this->guests.' '.($this->guests === 1 ? 'guest' : 'guests') : null,
            LeadType::Trade => trim(($this->organisation ?? '').($this->country ? ', '.$this->country : ''), ', ') ?: null,
            LeadType::Application => $this->jobPosting->title ?? 'General application',
            LeadType::Enquiry => isset($this->details['topic']) ? (string) (config('gdl.enquiry_topics.'.$this->details['topic']) ?? $this->details['topic']) : null,
        };
    }

    public function detail(string $key): mixed
    {
        return ($this->details ?? [])[$key] ?? null;
    }

    /** Rum names for the product keys a trade enquiry ticked. */
    public function productNames(): string
    {
        $keys = (array) $this->detail('products');

        return implode(', ', array_map(fn ($k) => Rums::get((string) $k)['name'] ?? (string) $k, $keys));
    }

    public function isOverdue(): bool
    {
        return $this->status === LeadStatus::New && $this->created_at->lt(now()->subHours(self::RESPONSE_HOURS));
    }

    /**
     * Moves to $status with a conditional UPDATE (only if the row still has the status this copy
     * read), so a double-submitted change is applied, and noted, once. Leaving New counts as the
     * first reply.
     */
    public function transition(LeadStatus $status): bool
    {
        if ($this->status === $status) {
            return false;
        }
        $changes = ['status' => $status, 'status_changed_at' => now()];
        if ($status !== LeadStatus::New && $this->first_contacted_at === null) {
            $changes['first_contacted_at'] = now();
        }

        return $this->claim(['status' => $this->status], $changes);
    }

    /**
     * Writes $changes only if the row still holds $expected (column => value read earlier).
     * Returns false, and reloads this copy, when another request changed it first.
     *
     * @param  array<string, mixed>  $expected
     * @param  array<string, mixed>  $changes
     */
    public function claim(array $expected, array $changes): bool
    {
        $query = static::query()->whereKey($this->getKey());
        foreach ($expected as $column => $value) {
            $value = $value instanceof \BackedEnum ? $value->value : $value;
            $value === null ? $query->whereNull($column) : $query->where($column, $value);
        }
        $this->forceFill($changes);
        $this->updateTimestamps();
        $dirty = $this->getDirty();

        if ($query->update($dirty) !== 1) {
            $this->refresh();

            return false;
        }
        $this->syncOriginalAttributes(array_keys($dirty));

        return true;
    }

    /**
     * Requests this user's role works on.
     *
     * @param  Builder<self>  $query
     */
    public function scopeVisibleTo(Builder $query, User $user): void
    {
        $query->whereIn('type', $user->leadTypeValues());
    }

    /**
     * The inbox order: new first, then newest first.
     *
     * @param  Builder<self>  $query
     */
    public function scopeInboxOrder(Builder $query): void
    {
        $query->orderByRaw("case when status = 'new' then 0 else 1 end")->orderByDesc('id');
    }

    /**
     * New and unanswered for longer than RESPONSE_HOURS.
     *
     * @param  Builder<self>  $query
     */
    public function scopeOverdue(Builder $query): void
    {
        $query->where('status', LeadStatus::New)->where('created_at', '<', now()->subHours(self::RESPONSE_HOURS));
    }

    /**
     * Tour bookings that hold places in a slot (everything except cancellations).
     *
     * @param  Builder<self>  $query
     */
    public function scopeHoldingTourPlaces(Builder $query): void
    {
        $query->where('type', LeadType::Tour)->where('status', '!=', LeadStatus::Cancelled)->whereNotNull('visit_date');
    }

    /**
     * @param  Builder<self>  $query
     * @param  array<string, mixed>  $f
     */
    public function scopeFilter(Builder $query, array $f): void
    {
        $query
            ->when($f['type'] ?? null, fn (Builder $q, $v) => $q->where('type', $v))
            ->when($f['status'] ?? null, fn (Builder $q, $v) => $v === 'open'
                ? $q->whereNotIn('status', array_map(fn (LeadStatus $s) => $s->value, LeadStatus::closed()))
                : $q->where('status', $v))
            ->when($f['assigned'] ?? null, fn (Builder $q, $v) => $v === 'none' ? $q->whereNull('assigned_to') : $q->where('assigned_to', $v))
            ->when($f['overdue'] ?? null, fn (Builder $q) => $q->overdue())
            ->when($f['q'] ?? null, function (Builder $q, $term) {
                $like = '%'.str_replace(['%', '_'], ['\%', '\_'], (string) $term).'%';
                $digits = preg_replace('/\D+/', '', (string) $term);
                $q->where(function (Builder $w) use ($like, $digits) {
                    $w->where('name', 'like', $like)->orWhere('reference', 'like', $like)->orWhere('email', 'like', $like)
                        ->orWhere('organisation', 'like', $like)->orWhere('country', 'like', $like);
                    if (strlen((string) $digits) >= 3) {
                        $w->orWhere('phone_digits', 'like', '%'.$digits.'%');
                    }
                });
            });
    }
}

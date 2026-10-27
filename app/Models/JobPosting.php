<?php

namespace App\Models;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $department
 * @property EmploymentType $employment_type
 * @property JobStatus $status
 * @property string $location
 * @property Carbon|null $closes_on
 * @property string $summary
 * @property string|null $duties
 * @property string|null $requirements
 * @property bool $is_demo
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class JobPosting extends Model
{
    protected $fillable = ['slug', 'title', 'department', 'employment_type', 'status', 'location', 'closes_on', 'summary', 'duties', 'requirements', 'is_demo'];

    #[\Override]
    protected function casts(): array
    {
        return [
            'employment_type' => EmploymentType::class,
            'status' => JobStatus::class,
            'closes_on' => 'date',
            'is_demo' => 'boolean',
        ];
    }

    #[\Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** @return HasMany<Lead, $this> */
    public function applications(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    /** @param Builder<self> $query */
    public function scopeOpen(Builder $query): void
    {
        $query->where('status', JobStatus::Open)
            ->where(fn (Builder $q) => $q->whereNull('closes_on')->orWhereDate('closes_on', '>=', today()));
    }

    public function isOpen(): bool
    {
        return $this->status === JobStatus::Open && ($this->closes_on === null || $this->closes_on->gte(today()));
    }

    /** @return list<string> */
    public function lines(string $field): array
    {
        return lines_to_array((string) $this->getAttribute($field));
    }
}

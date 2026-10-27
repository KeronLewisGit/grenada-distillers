<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\JobPosting;
use App\Models\User;

/** Vacancies are HR's: HR and administrators add, edit and close them. */
class JobPostingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::Hr, Role::Admin);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::Hr, Role::Admin);
    }

    public function update(User $user, JobPosting $job): bool
    {
        return $user->hasRole(Role::Hr, Role::Admin);
    }

    /** Only postings nobody has applied to can be deleted; the rest are closed instead. */
    public function delete(User $user, JobPosting $job): bool
    {
        return $user->hasRole(Role::Hr, Role::Admin);
    }
}

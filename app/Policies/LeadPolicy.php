<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Lead;
use App\Models\LeadFile;
use App\Models\User;

class LeadPolicy
{
    /** Each role sees the request types it works (Role::leadTypes); admins see all. */
    public function view(User $user, Lead $lead): bool
    {
        return $user->canWork($lead->type);
    }

    public function update(User $user, Lead $lead): bool
    {
        return $user->canWork($lead->type);
    }

    /** CVs open for HR and administrators only, and every opening is logged on the timeline. */
    public function openFile(User $user, Lead $lead, LeadFile $file): bool
    {
        if ($file->lead_id !== $lead->id) {
            return false;
        }
        if ($file->isHrDocument()) {
            return $user->hasRole(Role::Hr, Role::Admin);
        }

        return $this->view($user, $lead);
    }
}

<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Business;
use App\Models\User;

class BusinessPolicy
{
    /**
     * Admin can perform any action.
     */
    public function before(User $user): ?bool
    {
        if ($user->hasRole(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    /**
     * View any businesses.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            Role::JEEP_OWNER->value,
            Role::TRANSPORT_OWNER->value,
            Role::TOURIST->value,
        ]);
    }

    /**
     * View a specific business.
     */
    public function view(User $user, Business $business): bool
    {
        return $business->owner_id === $user->id;
    }

    /**
     * Create a business.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            Role::JEEP_OWNER->value,
            Role::TRANSPORT_OWNER->value,
        ]);
    }

    /**
     * Update a business.
     */
    public function update(User $user, Business $business): bool
    {
        return $business->owner_id === $user->id;
    }

    /**
     * Delete a business.
     */
    public function delete(User $user, Business $business): bool
    {
        return $business->owner_id === $user->id;
    }
}

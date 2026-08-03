<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BusinessPolicy
{
    /**
     * Admin can perform any action.
     */
    public function before(User $user, $ability): ?bool
    {
        // Admin can perform any action except changing the active status directly.
        if ($user->hasRole(Role::ADMIN->value) && $ability !== 'updateActive' && $ability !== 'update') {
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
            Role::ADMIN->value,
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
     * Admin or business owner can view available drivers
     */
    public function viewAvailable(User $user, Business $business): bool
    {
        return $user->hasRole('Admin') || $business->owner_id === $user->id;
    }

    
    /**
     * View vehicles for a specific business (Transport Owner).
     */
    public function viewBusinessVehicles(User $user, Business $business): Response
    {
        if ($user->hasRole('Transport Owner') && $business->owner_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to view vehicles for this business.');
    }

     /**
     * View Jeeps for a specific business (Jeep Owner).
     */
    public function viewBusinessJeeps(User $user, Business $business): Response
    {
        if ($user->hasRole('Jeep Owner') && $business->owner_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to view jeeps for this business.');
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
     * Update active status of a business (owner only).
     */
    public function updateActive(User $user, Business $business): bool
    {
        return $business->owner_id === $user->id;
    }

    /**
     * Update verification status of a business.
     */
    public function updateVerified(User $user, Business $business): bool
    {
        return $user->hasRole(Role::ADMIN->value);
    }

    /**
     * Delete a business.
     */
    public function delete(User $user, Business $business): bool
    {
        return $business->owner_id === $user->id;
    }
}

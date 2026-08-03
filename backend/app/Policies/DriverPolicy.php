<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\DriverProfile;
use App\Models\User;
use App\Enums\Role;  
use Illuminate\Auth\Access\Response;

class DriverPolicy
{
    /**
     * Only Jeep Owner and Transport Owner can create drivers.
     */
    public function create(User $user): Response
    {
        return $user->hasRole(Role::JEEP_OWNER->value) ||
             $user->hasRole(Role::TRANSPORT_OWNER->value)
            ? Response::allow()
            : Response::deny('Only Jeep Owners or Transport Owners can create drivers.');
    }

    /**
     * Business owner, assigned driver, or admin can view.
     */
    public function view(User $user, DriverProfile $driver): Response
    {
        return $user->hasRole('Admin') || $driver->business->owner_id === $user->id || $driver->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to view this driver.');
    }

    public function viewMe(User $user, DriverProfile $driver): Response
    {
        return $driver->user_id === $user->id
            ? Response::allow()
            : Response::deny('You can only view your own driver profile.');
    }

     public function viewAvailable(User $user, Business $business): Response
    {
        return $user->hasRole('Admin') || $business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to view available drivers.');
    }

    /**
     * Only the Business owner or the driver himself.
     */
    public function update(User $user, DriverProfile $driver): Response
    {
        return $driver->business->owner_id === $user->id || $driver->user_id === $user->id
            ? Response::allow()
            : Response::deny('You can only update drivers that belong to your business or yourself.');
    }

    /**
     * Only the owner of the business and Admin can delete.
     */
    public function delete(User $user, DriverProfile $driver): Response
    {
        return $user->hasRole('Admin') || $driver->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('Only admins or the business owner can delete this driver.');
    }

    /**
     * Business owner or the driver himself.
     */
    public function updateAvailability(User $user, DriverProfile $driver): Response {
        return $driver->business->owner_id === $user->id || $driver->user_id === $user->id
            ? Response::allow()
            : Response::deny('You can only update availability for drivers belonging to your business or yourself.');
    }

    /**
     * Admin only.
     */
    public function updateVerified(User $user, DriverProfile $driver): Response {
        return $user->hasRole('Admin')
            ? Response::allow()
            : Response::deny('Only administrators can update driver verification status.');
    }
}
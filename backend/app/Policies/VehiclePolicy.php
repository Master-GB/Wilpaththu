<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Business;
use Illuminate\Auth\Access\Response;

class VehiclePolicy
{
    /**
     * View all vehicles.
     */
    public function viewAny(User $user): Response
    {
        
         if($user->hasRole('Admin') ||$user->hasRole('Tour Guide') || $user->hasRole('Tourist') || $user->hasRole('Transport Driver')){
            return Response::allow();
        }

         return $user->can('vehicle.view')
            ? Response::allow()
            : Response::deny('You do not have permission to view this vehicle.');
    }

    /**
     * View a specific vehicle.
     */
    public function view(User $user, Vehicle $vehicle): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        // Transport owner can view only their own business vehicles
        if ($user->hasRole('Transport Owner')) {
            return $vehicle->business->owner_id === $user->id
                ? Response::allow()
                : Response::deny('You do not have permission to view this vehicle.');
        }

        // Driver can view only the assigned vehicle
        if ($user->hasRole('Transport Driver')) {
            $driver = $user->driverProfile;
            if (!$driver) {
                return Response::deny('You do not have permission to view this vehicle.');
            }
            return $vehicle->driver_id === $driver->id
                ? Response::allow()
                : Response::deny('You do not have permission to view this vehicle.');
        }

        return Response::deny('You do not have permission to view this vehicle.');
    }

    /**
     * Create vehicle.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('Transport Owner')
            ? Response::allow()
            : Response::deny('Only transport owners can create vehicles.');
    }

    /**
     * Update vehicle.
     */
    public function update(User $user, Vehicle $vehicle): Response
    {
        return $user->hasRole('Transport Owner') && $vehicle->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to update this vehicle.');
    }

    /**
     * Delete vehicle.
     */
    public function delete(User $user, Vehicle $vehicle): Response
    {
        return $user->hasRole('Transport Owner') && $vehicle->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to delete this vehicle.');
    }

    /**
     * Restore vehicle.
     */
    public function restore(User $user, Vehicle $vehicle): Response
    {
        return $user->hasRole('Transport Owner') && $vehicle->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to restore this vehicle.');
    }

    /**
     * Permanently delete vehicle.
     */
    public function forceDelete(User $user, Vehicle $vehicle): Response
    {
        return Response::deny('Force delete is not allowed for vehicles.');
    }

    /**
     * Assign driver.
     */
    public function assignDriver(User $user, Vehicle $vehicle): Response
    {
        return $user->hasRole('Transport Owner') && $vehicle->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to assign a driver to this vehicle.');
    }

    /**
     * Remove driver.
     */
    public function removeDriver(User $user, Vehicle $vehicle): Response
    {
        return $user->hasRole('Transport Owner') && $vehicle->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to remove the driver from this vehicle.');
    }

    /**
     * Change status.
     */
    public function changeStatus(User $user, Vehicle $vehicle): Response
    {
        // existing method unchanged
        return $user->hasRole('Transport Owner') && $vehicle->business->owner_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to change the status of this vehicle.');
    }

    /**
     * View vehicles for a specific business.
     */
    public function viewBusinessVehicles(User $user, Business $business): Response
    {
 
        if ($user->hasRole('Transport Owner') && $business->owner_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to view vehicles for this business.');
    }
    
}
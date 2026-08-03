<?php

namespace App\Policies;

use App\Models\Jeep;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JeepPolicy
{
    /**
     * View all jeeps.
     */
    public function viewAny(User $user): Response
    {

        if($user->hasRole('Admin') ||$user->hasRole('Tour Guide') || $user->hasRole('Tourist') || $user->hasRole('Jeep Driver')){
            return Response::allow();
        }

         return $user->can('jeep.view')
            ? Response::allow()
            : Response::deny('You do not have permission to view this jeep.');
    }

    /**
     * View a jeep.
     */
    public function view(User $user, Jeep $jeep): Response
    {
        if($user->hasRole('Admin') ||$user->hasRole('Tour Guide') || $user->hasRole('Tourist') || $user->hasRole('Jeep Driver')){
            return Response::allow();
        }

         return $user->can('jeep.view')
            ? Response::allow()
            : Response::deny('You do not have permission to view this jeep.');
    }

    /**
     * Create jeep.
     */
    public function create(User $user): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can register new jeeps.'
            );
        }

        return Response::allow();
    }

    /**
     * Update jeep.
     */
    public function update(User $user, Jeep $jeep): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can update jeeps.'
            );
        }

        if ($jeep->business->owner_id !== $user->id) {
            return Response::deny(
                'You can only update jeeps that belong to your own business.'
            );
        }

        return Response::allow();
    }

    /**
     * Delete jeep.
     */
    public function delete(User $user, Jeep $jeep): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can delete jeeps.'
            );
        }

        if ($jeep->business->owner_id !== $user->id) {
            return Response::deny(
                'You can only delete jeeps that belong to your own business.'
            );
        }

        return Response::allow();
    }

    /**
     * Restore jeep.
     */
    public function restore(User $user, Jeep $jeep): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can restore jeeps.'
            );
        }

        if ($jeep->business->owner_id !== $user->id) {
            return Response::deny(
                'You can only restore your own business jeeps.'
            );
        }

        return Response::allow();
    }

    /**
     * Permanently delete.
     */
    public function forceDelete(User $user, Jeep $jeep): Response
    {
        return $user->hasRole('Admin')
            ? Response::allow()
            : Response::deny(
                'Only administrators can permanently delete jeeps.'
            );
    }

    /**
     * Assign driver.
     */
    public function assignDriver(User $user, Jeep $jeep): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can assign drivers.'
            );
        }

        if ($jeep->business->owner_id !== $user->id) {
            return Response::deny(
                'You can only assign drivers to your own business jeeps.'
            );
        }

        return Response::allow();
    }

    /**
     * Remove driver.
     */
    public function removeDriver(User $user, Jeep $jeep): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can remove drivers.'
            );
        }

        if ($jeep->business->owner_id !== $user->id) {
            return Response::deny(
                'You can only remove drivers from your own business jeeps.'
            );
        }

        return Response::allow();
    }

    /**
     * Change jeep status.
     */
    public function changeStatus(User $user, Jeep $jeep): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if (! $user->hasRole('Jeep Owner')) {
            return Response::deny(
                'Only Jeep Owners can change jeep status.'
            );
        }

        if ($jeep->business->owner_id !== $user->id) {
            return Response::deny(
                'You can only change the status of your own business jeeps.'
            );
        }

        return Response::allow();
    }

    public function viewBusinessJeeps(User $user, Business $business): Response
    {
 
        if ($user->hasRole('Jeep Owner') && $business->owner_id === $user->id) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to view vehicles for this business.');
    }
    
}
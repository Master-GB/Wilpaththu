<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hotel;
use Illuminate\Auth\Access\Response;

class HotelPolicy
{
    /**
     * Anyone can view verified hotels.
     * Admin can view every hotel.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * View a single hotel.
     */
    public function view(User $user, Hotel $hotel): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if ($hotel->verified) {
            return Response::allow();
        }

        return $hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not authorized to view this hotel.');
    }

    /**
     * Only Hotel Owners can create a hotel.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('Hotel Owner')
            ? Response::allow()
            : Response::deny('Only Hotel Owners can create a hotel.');
    }

    public function getMyHotel(User $user, Hotel $hotel): Response
    {
        return $hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('You can only access your own hotel.');
    }

    /**
     * Only the owner or Admin can update.
     */
    public function update(User $user, Hotel $hotel): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('Only the hotel owner or admin can update this hotel.');
    }

    /**
     * Only the owner or Admin can delete.
     */
    public function delete(User $user, Hotel $hotel): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('Only the hotel owner or admin can delete this hotel.');
    }

    /**
     * Only Admin can restore.
     */
    public function restore(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Hotel Owner or Admin.
     */
    public function updateStatus(
        User $user,
        Hotel $hotel
    ): Response {

        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('Only the hotel owner or admin can update status of this hotel.');
    }

    /**
     * Admin only.
     */
    public function updateVerification(
        User $user
    ): bool {

        return $user->hasRole('Admin');
    }

    /**
     * Admin only.
     */
    public function updateStarRating(
        User $user
    ): bool {

        return $user->hasRole('Admin');
    }

    /**
     * Admin only.
     */
    public function updateFeaturedType(
        User $user
    ): bool {

        return $user->hasRole('Admin');
    }
}
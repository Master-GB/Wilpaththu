<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hotel;

class HotelPolicy
{
    /**
     * Anyone can view verified hotels.
     * Admin can view every hotel.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * View a single hotel.
     */
    public function view(User $user, Hotel $hotel): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($hotel->verified) {
            return true;
        }

        return $hotel->user_id === $user->id;
    }

    /**
     * Only Hotel Owners can create a hotel.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Hotel Owner');
    }

    /**
     * Only the owner or Admin can update.
     */
    public function update(User $user, Hotel $hotel): bool
    {
        return
            $user->hasRole('Admin') ||
            $hotel->user_id === $user->id;
    }

    /**
     * Only the owner or Admin can delete.
     */
    public function delete(User $user, Hotel $hotel): bool
    {
        return
            $user->hasRole('Admin') ||
            $hotel->user_id === $user->id;
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
    ): bool {

        return
            $user->hasRole('Admin') ||
            $hotel->user_id === $user->id;
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
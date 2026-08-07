<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoomPolicy
{
    /**
     * View any rooms.
     */
    public function viewAny(User $user): Response
    {
        // Only admins can list rooms
        if ($user->hasRole('Admin') || $user->hasRole('Hotel Owner')) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to view rooms.');
    }

    /**
     * View a room.
     */
    public function view(User $user, Room $room): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $room->hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to view this room.');
    }

    /**
     * Create room.
     */
    public function create(User $user): Response
    {
        if ($user->hasRole('Admin') || $user->hasRole('Hotel Owner')) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to create a room.');
    }

    /**
     * Update room.
     */
    public function update(User $user, Room $room): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $room->hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to update this room.');
    }

    /**
     * Delete room.
     */
    public function delete(User $user, Room $room): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $room->hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to delete this room.');
    }

    /**
     * Restore room.
     */
    public function restore(User $user, Room $room): Response
    {
        return $user->hasRole('Admin')
            ? Response::allow()
            : Response::deny('You do not have permission to restore this room..');
    }

    /**
     * Update room status.
     */
    public function updateStatus(User $user, Room $room): Response
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }
        return $room->hotel->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not have permission to update Status Of this room.');
    }
}
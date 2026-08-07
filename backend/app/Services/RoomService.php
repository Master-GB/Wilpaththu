<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\HttpException;  
use App\DTOs\StoreRoomData;
use App\DTOs\UpdateRoomData;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Validation\ValidationException;
use App\Contracts\Services\RoomServiceInterface;
use App\Contracts\Services\HotelServiceInterface;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\DTOs\UpdateRoomStatusData;

class RoomService implements RoomServiceInterface
{
    public function __construct(
        private readonly RoomRepositoryInterface $roomRepository,
        private readonly HotelServiceInterface $hotelService,
    ) {}

    public function getAll(){
        return $this->roomRepository->getAll();
    }

    /**
     * Create a room.
     */
    public function createRoom(StoreRoomData $data): Room{
        $hotel = $this->getOwnerHotel();

        if (!$hotel) {

            throw ValidationException::withMessages([
                'hotel' => 'Hotel not found.',
            ]);
        }

        if ($this->roomRepository->roomNumberExists(
            $hotel->id,
            $data->roomNumber
        )) {

            throw ValidationException::withMessages([
                'room_number' => 'Room number already exists.',
            ]);
        }

        if ($hotel->user_id !== auth()->id() && !auth()->user()?->hasRole('Admin')) {
            throw new HttpException(
            403,
            'You do not own this Hotel.'
            );
        }


        return $this->roomRepository->createRoom([

            'hotel_id' => $hotel->id,

            'room_number' => $data->roomNumber,

            'room_name' => $data->roomName,

            'description' => $data->description,

            'room_type' => $data->roomType,

            'floor_number' => $data->floorNumber,

            'max_adults' => $data->maxAdults,

            'max_children' => $data->maxChildren,

            'max_occupancy' => $data->maxOccupancy,

            'bed_type' => $data->bedType,

            'bed_count' => $data->bedCount,

            'room_size' => $data->roomSize,

            'room_size_unit' => $data->roomSizeUnit,

            'view_types' => $data->viewTypes,

            'bathroom_type' => $data->bathroomType,

            'smoking_allowed' => $data->smokingAllowed,

            'pets_allowed' => $data->petsAllowed,

            'accessible_room' => $data->accessibleRoom,

            'amenities' => $data->amenities,

            'status' => $data->status ?? \App\Enums\RoomStatusEnum::ACTIVE->value,
        ]);
    }

    /**
     * Find room by ID.
     */
    public function findById(int $id): ?Room{
        return $this->roomRepository->findById($id);
    }

    /**
     * Get all rooms of the authenticated owner's hotel.
     */
    public function getMyHotelRooms(){
        $hotel = $this->getOwnerHotel();

        // Ensure the authenticated user owns the hotel or is an admin
        if ($hotel->user_id !== auth()->id() && !auth()->user()?->hasRole('Admin')) {
            throw new HttpException(
                403,
                'You do not have permission to view rooms of this hotel.'
            );
        }

        return $this->roomRepository->getHotelRooms(
            $hotel->id
        );
    }

    /**
     * Update room.
     */
    public function update(Room $room,UpdateRoomData $data): Room {

        if (
            $data->roomNumber &&
            $this->roomRepository->roomNumberExists(
                $room->hotel_id,
                $data->roomNumber,
                $room->id
            )
        ) {

            throw ValidationException::withMessages([
                'room_number' => [
                    'Room number already exists.'
                ]
            ]);
        }

        return $this->roomRepository->update($room, array_filter([

            'room_number' => $data->roomNumber,

            'room_name' => $data->roomName,

            'description' => $data->description,

            'room_type' => $data->roomType,

            'floor_number' => $data->floorNumber,

            'max_adults' => $data->maxAdults,

            'max_children' => $data->maxChildren,

            'max_occupancy' => $data->maxOccupancy,

            'bed_type' => $data->bedType,

            'bed_count' => $data->bedCount,

            'room_size' => $data->roomSize,

            'room_size_unit' => $data->roomSizeUnit,

            'view_types' => $data->viewTypes,

            'bathroom_type' => $data->bathroomType,

            'smoking_allowed' => $data->smokingAllowed,

            'pets_allowed' => $data->petsAllowed,

            'accessible_room' => $data->accessibleRoom,

            'amenities' => $data->amenities,

            'status' => $data->status,

        ], fn($value) => $value !== null));
    }

        /**
     * Update room status.
     */
    public function updateStatus(Room $room, UpdateRoomStatusData $data): Room {
        // Ensure the authenticated user owns the hotel or is an admin
        $hotel = $this->getOwnerHotel();

        if ($room->hotel_id !== $hotel->id && !auth()->user()?->hasRole('Admin')) {
            throw new HttpException(
                403,
                'You do not have permission to update status of this room.'
            );
        }

        return $this->roomRepository->updateStatus(
            $room,
            $data->status
        );
    }


    /**
     * Delete room.
     */
    public function delete(Room $room): void{
        $this->roomRepository->delete($room);
    }


    /**
     * Restore deleted room.
     */
    public function restore(int $id): Room{
        return $this->roomRepository->restore($id);
    }


    /**
     * Get available rooms of authenticated owner's hotel.
     */
    public function getAvailableRooms(){
        $hotel = $this->getOwnerHotel();

        return $this->roomRepository->getAvailableRooms(
            $hotel->id
        );
    }


    /**
     * Get authenticated owner's hotel.
     */
    private function getOwnerHotel(): Hotel{
        $hotel = $this->hotelService
            ->findByOwner(auth()->id());

        if (!$hotel) {

            throw ValidationException::withMessages([
                'hotel' => [
                    'Hotel not found for this user.'
                ]
            ]);
        }

        return $hotel;
    }
}
<?php

namespace App\Repositories;

use App\Models\Room;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Enums\RoomStatusEnum;

class RoomRepository implements RoomRepositoryInterface
{
    public function createRoom(array $data): Room
    {
        return Room::create($data);
    }

    public function findById(int $id): ?Room
    {
        return Room::with('hotel')->find($id);
    }

    public function getHotelRooms(int $hotelId)
    {
        return Room::with('hotel')
            ->where('hotel_id', $hotelId)
            ->latest()
            ->get();
    }

    public function roomNumberExists(int $hotelId,string $roomNumber,?int $ignoreRoomId = null): bool {

        $query = Room::where('hotel_id', $hotelId)
        ->where('room_number', $roomNumber);

        if ($ignoreRoomId) {
            $query->where('id', '!=', $ignoreRoomId);
        }

        return $query->exists();
    }


    public function update(
        Room $room,
        array $data
    ): Room {

        $room->update($data);

        return $room->refresh();
    }

    public function updateStatus(
        Room $room,
        string $status
    ): Room {

        $room->update([
            'status' => $status,
        ]);

        return $room->refresh();
    }

    public function delete(Room $room): void
    {
        $room->delete();
    }

    public function restore(int $id): Room
    {
        $room = Room::withTrashed()
            ->findOrFail($id);

        $room->restore();

        return $room->refresh();
    }


    public function getAvailableRooms(int $hotelId)
    {
        return Room::where('hotel_id', $hotelId)
            ->where('status', RoomStatusEnum::ACTIVE->value)
            ->latest()
            ->get();
    }

}

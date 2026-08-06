<?php

namespace App\Contracts\Repositories;

use App\Models\Room;

interface RoomRepositoryInterface
{
    public function createRoom(array $data): Room;

    public function findById(int $id): ?Room;

    public function getHotelRooms(int $hotelId);

    public function findRoomByNumber(
        int $hotelId,
        string $roomNumber
    ): ?Room;

    public function update(
        Room $room,
        array $data
    ): Room;

    public function updateStatus(
        Room $room,
        string $status
    ): Room;

    public function delete(Room $room): void;

    public function restore(int $id): Room;

    public function getAvailableRooms(int $hotelId);
}
<?php

namespace App\Contracts\Services;

use App\DTOs\StoreRoomData;
use App\DTOs\UpdateRoomData;
use App\Models\Room;

interface RoomServiceInterface
{
    public function createRoom(StoreRoomData $data): Room;

    public function findById(int $id): ?Room;

    public function getMyHotelRooms();

    public function update(Room $room, UpdateRoomData $data): Room;

    public function updateStatus(Room $room, string $status): Room;

    public function delete(Room $room): void;

    public function restore(int $id): Room;

    public function getAvailableRooms();
}
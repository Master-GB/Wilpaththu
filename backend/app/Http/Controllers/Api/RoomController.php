<?php

namespace App\Http\Controllers\Api;

use App\DTOs\StoreRoomData;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Requests\UpdateRoomStatusRequest;
use App\Http\Resources\RoomResource;
use App\Contracts\Services\RoomServiceInterface;
use App\DTOs\UpdateRoomData;
use App\DTOs\UpdateRoomStatusData;

class RoomController extends Controller
{
    public function __construct(
        private readonly RoomServiceInterface $roomService
    ) {}

    /**
     * Display all rooms.
     */
    public function index(): JsonResponse{
        $this->authorize('viewAny', Room::class);

        $rooms = $this->roomService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully.',
            'data' => RoomResource::collection($rooms),
        ]);
    }

    /**
     * Get authenticated hotel owner's rooms.
     */
    public function getMyHotelRooms(): JsonResponse{
        // Use viewAny because the policy's view method expects a Room instance
        $this->authorize('viewAny', Room::class);

        $rooms = $this->roomService->getMyHotelRooms();

        return response()->json([
            'success' => true,
            'message' => 'Hotel rooms retrieved successfully.',
            'data' => RoomResource::collection($rooms),
        ]);
    }

    /**
     * Store room.
     */
    public function store(StoreRoomRequest $request): JsonResponse {

        $this->authorize('create', Room::class);

        $room = $this->roomService->createRoom(
            StoreRoomData::fromRequest($request)
        );

        return response()->json([
            'success' => true,
            'message' => 'Room created successfully.',
            'data' => new RoomResource($room),
        ], 201);
    }

    /**
     * Show room.
     */
    public function show(Room $room): JsonResponse{
        $this->authorize('view', $room);

        return response()->json([
            'success' => true,
            'message' => 'Room retrieved successfully.',
            'data' => new RoomResource($room),
        ]);
    }

        /**
     * Update room.
     */
    public function update(UpdateRoomRequest $request,Room $room): JsonResponse {

        $this->authorize('update', $room);

        $room = $this->roomService->update(
            $room,
            UpdateRoomData::fromRequest($request)
        );

        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully.',
            'data' => new RoomResource($room),
        ]);
    }

    /**
     * Update room status.
     */
    public function updateStatus(UpdateRoomStatusRequest $request,Room $room): JsonResponse {

        $this->authorize('updateStatus', $room);

        $room = $this->roomService->updateStatus(
            $room,
            UpdateRoomStatusData::fromRequest($request)
        );

        return response()->json([
            'success' => true,
            'message' => 'Room status updated successfully.',
            'data' => new RoomResource($room),
        ]);
    }

    /**
     * Delete room.
     */
    public function destroy(Room $room): JsonResponse {
        $this->authorize('delete', $room);

        $this->roomService->delete($room);

        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully.',
        ]);
    }

    /**
     * Restore room.
     */
    public function restore(int $id): JsonResponse{
        $room = $this->roomService->restore($id);

        $this->authorize('restore', $room);

        return response()->json([
            'success' => true,
            'message' => 'Room restored successfully.',
            'data' => new RoomResource($room),
        ]);
    }

    /**
 * Get available rooms.
 */
    public function getAvailableRooms(): JsonResponse{
        $this->authorize('viewAny', Room::class);

        $rooms = $this->roomService->getAvailableRooms();

        return response()->json([
        'success' => true,
        'message' => 'Available rooms retrieved successfully.',
        'data' => RoomResource::collection($rooms),
    ]);
}

}

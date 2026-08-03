<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\VehicleServiceInterface;
use App\DTOs\StoreVehicleData;
use App\DTOs\UpdateVehicleData;
use App\DTOs\UpdateVehicleStatusData;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Requests\UpdateVehicleStatusRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Models\Business;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends BaseApiController
{
    public function __construct(
        private readonly VehicleServiceInterface $vehicleService
    ) {}

    /**
     * Display all vehicles.
     */
    public function index(): JsonResponse{
        $this->authorize('viewAny', Vehicle::class);

        return $this->success(
            VehicleResource::collection(
                $this->vehicleService->getAllVehicles()
            ),
            'Vehicles retrieved successfully.'
        );
    }

    /**
     * Store a new vehicle.
     */
    public function store(StoreVehicleRequest $request): JsonResponse{
        $this->authorize('create', Vehicle::class);

        $vehicle = $this->vehicleService->createVehicle(
            StoreVehicleData::fromRequest($request)
        );

        return $this->success(
            new VehicleResource($vehicle),
            'Vehicle created successfully.',
            201
        );
    }

    /**
     * Display a vehicle.
     */
    public function show(Vehicle $vehicle): JsonResponse{
        $this->authorize('view', $vehicle);

        return $this->success(
            new VehicleResource(
                $this->vehicleService->findVehicleById($vehicle->id)
            ),
            'Vehicle retrieved successfully.'
        );
    }

    /**
     * Update vehicle.
     */
    public function update(UpdateVehicleRequest $request,Vehicle $vehicle): JsonResponse {

        $this->authorize('update', $vehicle);

        $vehicle = $this->vehicleService->updateVehicle(
            $vehicle,
            UpdateVehicleData::fromRequest($request)
        );

        return $this->success(
            new VehicleResource($vehicle),
            'Vehicle updated successfully.'
        );
    }

    /**
     * Delete vehicle.
     */
    public function destroy(Vehicle $vehicle): JsonResponse{
        $this->authorize('delete', $vehicle);

        $this->vehicleService->deleteVehicle($vehicle);

        return $this->success(
            null,
            'Vehicle deleted successfully.'
        );
    }

    /**
     * Assign driver.
     */
    public function assignDriver(Request $request,Vehicle $vehicle): JsonResponse {

        $this->authorize('assignDriver', $vehicle);

        $request->validate([
            'driver_id' => [
                'required',
                'exists:driver_profiles,id',
            ],
        ]);

        $vehicle = $this->vehicleService->assignDriver(
            $vehicle,
            $request->driver_id
        );

        return $this->success(
            new VehicleResource($vehicle),
            'Driver assigned successfully.'
        );
    }

    /**
     * Remove driver.
     */
    public function removeDriver(Vehicle $vehicle): JsonResponse {

        $this->authorize('removeDriver', $vehicle);

        $vehicle = $this->vehicleService->removeDriver($vehicle);

        return $this->success(
            new VehicleResource($vehicle),
            'Driver removed successfully.'
        );
    }

    /**
     * Change vehicle status.
     */
    public function changeStatus(UpdateVehicleStatusRequest $request,Vehicle $vehicle): JsonResponse {

        $this->authorize('changeStatus', $vehicle);

        $vehicle = $this->vehicleService->changeStatus(
            $vehicle,
            UpdateVehicleStatusData::fromRequest($request)
        );

        return $this->success(
            new VehicleResource($vehicle),
            'Vehicle status updated successfully.'
        );
    }
    /**
     * Get all vehicles belonging to a specific business.
     */
    public function getBusinessVehicles(Request $request, Business $business): JsonResponse {
        $this->authorize('viewBusinessVehicles', $business);
        $vehicles = $this->vehicleService->getVehiclesByBusiness($business->id);
        return $this->success(
            VehicleResource::collection($vehicles),
            'Business vehicles retrieved successfully.'
        );
    }
}

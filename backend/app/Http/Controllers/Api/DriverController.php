<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\DriverServiceInterface;
use App\DTOs\CreateDriverData;
use App\DTOs\UpdateDriverAvailabilityData;
use App\DTOs\UpdateDriverData;
use App\DTOs\UpdateDriverVerificationData;
use App\Http\Requests\CreateDriverRequest;
use App\Http\Requests\UpdateDriverAvailabilityRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Requests\UpdateDriverVerificationRequest;
use App\Http\Resources\DriverResource;
use App\Models\Business;
use App\Models\DriverProfile;
use Illuminate\Http\JsonResponse;

class DriverController extends BaseApiController
{
    public function __construct(
        private readonly DriverServiceInterface $driverService
    ) {}

    /**
     * Create Driver
     */
    public function store(CreateDriverRequest $request): JsonResponse {

        $this->authorize('create', DriverProfile::class);

        $result = $this->driverService->createDriver(
            CreateDriverData::fromRequest($request)
        );

        return $this->success(
            [
                'driver' => new DriverResource($result['driver']),
                'credentials' => $result['credentials'],
            ],
            'Driver created successfully.',
            201
        );
    }

    /**
     * Driver Details
     */
    public function show(DriverProfile $driver): JsonResponse {

        $this->authorize('view', $driver);

        return $this->success(
            new DriverResource(
                $this->driverService->findById($driver->id)
            ),
            'Driver retrieved successfully.'
        );
    }

    /**
     * Business Drivers
     */
    public function businessDrivers(Business $business): JsonResponse {

        $this->authorize('view', $business);

        return $this->success(
            DriverResource::collection(
                $this->driverService->getBusinessDrivers(
                    $business->id
                )
            ),
            'Drivers retrieved successfully.'
        );
    }

    /**
     * Available Drivers
     */
    public function availableDrivers(Business $business): JsonResponse {

        $this->authorize('viewAvailable', $business);

        return $this->success(
            DriverResource::collection(
                $this->driverService->getAvailableDrivers(
                    $business->id
                )
            ),
            'Available drivers retrieved successfully.'
        );
    }

    /**
     * Update Driver
     */
    public function update(UpdateDriverRequest $request, DriverProfile $driver): JsonResponse {

        $this->authorize('update', $driver);

        $driver = $this->driverService->updateProfile(
            $driver,
            UpdateDriverData::fromRequest($request)
        );

        return $this->success(
            new DriverResource($driver),
            'Driver updated successfully.'
        );
    }

    /**
     * Update Availability
     */
    public function updateAvailability(UpdateDriverAvailabilityRequest $request, DriverProfile $driver): JsonResponse {

        $this->authorize('updateAvailability', $driver);

        $driver = $this->driverService->updateAvailability(
            $driver,
            UpdateDriverAvailabilityData::fromRequest($request)
        );

        return $this->success(
            new DriverResource($driver),
            'Driver availability updated successfully.'
        );
    }

    /**
     * Verify Driver
     */
    public function updateVerified(UpdateDriverVerificationRequest $request, DriverProfile $driver): JsonResponse {

        $this->authorize('updateVerified', $driver);

        $driver = $this->driverService->updateVerified(
            $driver,
            UpdateDriverVerificationData::fromRequest($request)
        );

        return $this->success(
            new DriverResource($driver),
            'Driver verification updated successfully.'
        );
    }

    /**
     * Delete Driver
     */
    public function destroy(DriverProfile $driver): JsonResponse {

        $this->authorize('delete', $driver);

        $this->driverService->deleteProfile($driver);

        return $this->success(
            null,
            'Driver deleted successfully.'
        );
    }

    /**
    * Get authenticated driver's profile.
    */
    public function me(): JsonResponse{
    $driver = $this->driverService->findDriverByUser(
        auth()->id()
    );

    if (! $driver) {

        return $this->error(
            'Driver profile not found.',
            404
        );
    }

    $this->authorize('viewMe', $driver);

    return $this->success(
        new DriverResource($driver),
        'Driver profile retrieved successfully.'
    );
    }

}
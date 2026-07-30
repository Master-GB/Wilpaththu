<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\JeepServiceInterface;
use App\DTOs\StoreJeepData;
use App\DTOs\UpdateJeepData;
use App\Http\Requests\StoreJeepRequest;
use App\Http\Requests\UpdateJeepRequest;
use App\Http\Resources\JeepResource;
use App\Models\Jeep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JeepController extends BaseApiController
{
    public function __construct(
        private readonly JeepServiceInterface $jeepService
    ) {}

    public function index(): JsonResponse
    {
        return $this->success(
            JeepResource::collection(
                $this->jeepService->getAllJeeps()
            ),
            'Jeeps retrieved successfully.'
        );
    }

    public function store(StoreJeepRequest $request): JsonResponse
    {
        $jeep = $this->jeepService->createJeep(
            StoreJeepData::fromRequest($request)
        );

        return $this->success(
            new JeepResource($jeep),
            'Jeep created successfully.',
            201
        );
    }

    public function show(Jeep $jeep): JsonResponse
    {
        return $this->success(
            new JeepResource(
                $this->jeepService->findJeepById($jeep->id)
            ),
            'Jeep retrieved successfully.'
        );
    }

    public function update(
        UpdateJeepRequest $request,
        Jeep $jeep
    ): JsonResponse {

        $jeep = $this->jeepService->updateJeep(
            $jeep,
            UpdateJeepData::fromRequest($request)
        );

        return $this->success(
            new JeepResource($jeep),
            'Jeep updated successfully.'
        );
    }

    public function destroy(Jeep $jeep): JsonResponse
    {
        $this->jeepService->deleteJeep($jeep);

        return $this->success(
            null,
            'Jeep deleted successfully.'
        );
    }

    public function assignJeepDriver(
        Request $request,
        Jeep $jeep
    ): JsonResponse {

        $request->validate([
            'driver_id' => [
                'required',
                'exists:users,id'
            ],
        ]);

        $jeep = $this->jeepService->assignJeepDriver(
            $jeep,
            $request->driver_id
        );

        return $this->success(
            new JeepResource($jeep),
            'Driver assigned successfully.'
        );
    }

    public function removeJeepDriver(Jeep $jeep): JsonResponse
    {
        $jeep = $this->jeepService->removeJeepDriver($jeep);

        return $this->success(
            new JeepResource($jeep),
            'Driver removed successfully.'
        );
    }

    public function changeJeepStatus(
        Request $request,
        Jeep $jeep
    ): JsonResponse {

        $request->validate([
            'status' => [
                'required',
                'in:Available,Maintenance,Inactive'
            ],
        ]);

        $jeep = $this->jeepService->changeJeepStatus(
            $jeep,
            $request->status
        );

        return $this->success(
            new JeepResource($jeep),
            'Status updated successfully.'
        );
    }
}
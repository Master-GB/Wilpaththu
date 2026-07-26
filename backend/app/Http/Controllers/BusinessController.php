<?php

namespace App\Http\Controllers;

use App\Contracts\Services\BusinessServiceInterface;
use App\DTOs\BusinessData;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BusinessController extends BaseApiController
{
    public function __construct(
        private readonly BusinessServiceInterface $businessService
    ) {}

    /**
     * Display a listing of businesses.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Business::class);

        $businesses = $this->businessService->all();

        return $this->success(
            BusinessResource::collection($businesses),
            'Businesses retrieved successfully.'
        );
    }

    /**
     * Store a newly created business.
     */
    public function store(StoreBusinessRequest $request): JsonResponse
    {
        $this->authorize('create', Business::class);

        $data = BusinessData::fromRequest($request);

        $business = $this->businessService->create(
            $request->user()->id,
            $data
        );

        $business->load('owner');

        return $this->success(
            new BusinessResource($business),
            'Business created successfully.',
            201
        );
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business): JsonResponse
    {
        $this->authorize('view', $business);

        $business->load('owner');

        return $this->success(
            new BusinessResource($business),
            'Business retrieved successfully.'
        );
    }

    /**
     * Update the specified business.
     */
    public function update(
        UpdateBusinessRequest $request,
        Business $business
    ): JsonResponse {
        $this->authorize('update', $business);

        $data = BusinessData::fromRequest($request);

        $business = $this->businessService->update(
            $business,
            $data
        );

        $business->load('owner');

        return $this->success(
            new BusinessResource($business),
            'Business updated successfully.'
        );
    }

    /**
     * Remove the specified business.
     */
    public function destroy(Business $business): JsonResponse
    {
        $this->authorize('delete', $business);

        $this->businessService->delete($business);

        return $this->success(
            null,
            'Business deleted successfully.'
        );
    }
}

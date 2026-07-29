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
        try {
            $this->authorize('create', Business::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return $this->error('This action is unauthorized.', null, 403);
        }

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
        try {
            $this->authorize('update', $business);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return $this->error('This action is unauthorized.', null, 403);
        }

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
     * Update verification status of the business.
     */
    public function verify(Request $request, Business $business): JsonResponse
    {
        $this->authorize('updateVerified', $business);

        $validated = $request->validate([
            'is_verified' => ['required', 'boolean'],
            'verified_at' => ['nullable', 'date'],
        ]);

        $business->update([
            'is_verified' => $validated['is_verified'],
            'verified_at' => $validated['is_verified']
                ? ($validated['verified_at'] ?? now())
                : null,
        ]);

        $business->load('owner');

        return $this->success(
            new BusinessResource($business),
            'Business verification status updated.'
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

    /**
     * Update active status of a business (owner only).
     */
    public function updateActive(Request $request, Business $business): JsonResponse
    {
        $this->authorize('updateActive', $business);

        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $business->update([
            'is_active' => $validated['is_active'],
        ]);

        $business->load('owner');

        return $this->success(
            new BusinessResource($business),
            'Business active status updated.'
        );
    }
}

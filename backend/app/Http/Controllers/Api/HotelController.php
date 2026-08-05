<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\HotelResource;
use App\Contracts\Services\HotelServiceInterface;
use App\DTOs\StoreHotelData;
use App\DTOs\UpdateHotelData;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\DTOs\UpdateHotelStatusData;
use App\Http\Requests\UpdateHotelStatusRequest;
use App\DTOs\UpdateHotelStarRatingData;
use App\Http\Requests\UpdateHotelStarRatingRequest;
use App\DTOs\UpdateHotelVerificationData;
use App\Http\Requests\UpdateHotelVerificationRequest;
use App\DTOs\UpdateHotelFeaturedTypeData;
use App\Http\Requests\UpdateHotelFeaturedTypeRequest;

class HotelController extends BaseApiController
{

    // add get all hotel with unverified hotel(leter we can filter that) and  add only get verified hote
    public function __construct(
        private readonly HotelServiceInterface $hotelService
    ) {}

    public function index(): JsonResponse
    {

        $this->authorize('viewAny', Hotel::class); // later we need to modify this.. policy also need change related to this..

        return $this->success(
            HotelResource::collection(
                $this->hotelService->getAll()
            ),
            'Hotels retrieved successfully.'
        );
    }

    public function store(
        StoreHotelRequest $request
    ): JsonResponse {

        $this->authorize('create', Hotel::class);

        $hotel = $this->hotelService->create(
            StoreHotelData::fromRequest($request)
        );

        return $this->success(
            new HotelResource($hotel),
            'Hotel created successfully.',
            201
        );
    }

    public function show(
        Hotel $hotel
    ): JsonResponse {

        $this->authorize('view', $hotel);

        return $this->success(
            new HotelResource($hotel),
            'Hotel retrieved successfully.'
        );
    }

    public function update(
        UpdateHotelRequest $request,
        Hotel $hotel
    ): JsonResponse {

        $this->authorize('update', $hotel);

        $hotel = $this->hotelService->update(
            $hotel,
            UpdateHotelData::fromRequest($request)
        );

        return $this->success(
            new HotelResource($hotel),
            'Hotel updated successfully.'
        );
    }

    public function destroy(
        Hotel $hotel
    ): JsonResponse {

        $this->authorize('delete', $hotel);

        $this->hotelService->delete($hotel);

        return $this->success(
            null,
            'Hotel deleted successfully.'
        );
    }

    public function getMyHotel(): JsonResponse
    {
        $hotel = $this->hotelService
            ->findByOwner(auth()->id());

        $this->authorize('getMyHotel', $hotel);
        
        if (!$hotel) {

            return $this->error(
                'Hotel not found.',
                404
            );
        }

        return $this->success(
            new HotelResource($hotel),
            'Hotel retrieved successfully.'
        );
    }

    public function showBySlug(string $slug): JsonResponse
    {
           $hotel = $this->hotelService->findBySlug($slug);

            if (!$hotel) {
                 return $this->error(
                    'Hotel not found.',
                      404
                );
            }

            return $this->success(
                 new HotelResource($hotel),
                'Hotel retrieved successfully.'
            );
    }

    public function updateStatus(
        UpdateHotelStatusRequest $request,
        Hotel $hotel
    ): JsonResponse {

        $this->authorize('updateStatus', $hotel);

        $hotel = $this->hotelService->updateStatus(
            $hotel,
            UpdateHotelStatusData::fromRequest($request)
        );

        return $this->success(
            new HotelResource($hotel),
            'Hotel status updated successfully.'
        );
    }

    public function updateVerification(
        UpdateHotelVerificationRequest $request,
        Hotel $hotel
    ): JsonResponse {

        $this->authorize(
            'updateVerification',
            $hotel
        );

        $hotel = $this->hotelService->updateVerification(
            $hotel,
            UpdateHotelVerificationData::fromRequest($request)
        );

        return $this->success(
            new HotelResource($hotel),
            'Hotel verification updated successfully.'
        );
    }

    public function updateStarRating(
        UpdateHotelStarRatingRequest $request,
        Hotel $hotel
    ): JsonResponse {

        $this->authorize(
            'updateStarRating',
            $hotel
        );

        $hotel = $this->hotelService->updateStarRating(
            $hotel,
            UpdateHotelStarRatingData::fromRequest($request)
        );

        return $this->success(
            new HotelResource($hotel),
            'Hotel star rating updated successfully.'
        );
    }

    public function updateFeaturedType(
        UpdateHotelFeaturedTypeRequest $request,
        Hotel $hotel
    ): JsonResponse {

        $this->authorize(
            'updateFeaturedType',
            $hotel
        );

        $hotel = $this->hotelService->updateFeaturedType(
            $hotel,
            UpdateHotelFeaturedTypeData::fromRequest($request)
        );

        return $this->success(
            new HotelResource($hotel),
            'Hotel featured type updated successfully.'
        );
    }

    public function restore(
        int $id
    ): JsonResponse {

        $this->authorize(
            'restore',
            Hotel::class
        );

        $hotel = $this->hotelService->restore($id);

        return $this->success(
            new HotelResource($hotel),
            'Hotel restored successfully.'
        );
    }
}
<?php

namespace App\Contracts\Services;

use App\DTOs\StoreHotelData;
use App\DTOs\UpdateHotelData;
use App\DTOs\UpdateHotelStatusData;
use App\DTOs\UpdateHotelStarRatingData;
use App\DTOs\UpdateHotelVerificationData;
use App\DTOs\UpdateHotelFeaturedTypeData;
use App\Models\Hotel;

interface HotelServiceInterface
{
    public function create(StoreHotelData $data): Hotel;

    public function getAll();

    public function findById(int $id): ?Hotel;

    public function findByOwner(int $userId): ?Hotel;

    public function findBySlug(string $slug): ?Hotel;

    public function update(Hotel $hotel,UpdateHotelData $data): Hotel;

    public function updateStatus(Hotel $hotel,UpdateHotelStatusData $data): Hotel;

    public function updateVerification(Hotel $hotel,UpdateHotelVerificationData $data): Hotel;

    public function updateStarRating(Hotel $hotel,UpdateHotelStarRatingData $data): Hotel;

    public function updateFeaturedType(Hotel $hotel,UpdateHotelFeaturedTypeData $data): Hotel;

    public function delete(Hotel $hotel): void;

    public function restore(int $id): Hotel;
}
<?php

namespace App\Contracts\Repositories;

use App\Models\Hotel;

interface HotelRepositoryInterface
{
    public function create(array $data): Hotel;

    public function getAll();

    public function findById(int $id): ?Hotel;

    public function findByOwner(int $userId): ?Hotel;

    public function findBySlug(string $slug): ?Hotel;

    public function update(Hotel $hotel,array $data): Hotel;

    public function updateStatus(Hotel $hotel,string $status): Hotel;

    public function updateVerification(Hotel $hotel,bool $verified): Hotel;

    public function updateStarRating(Hotel $hotel,?int $starRating): Hotel;

    public function updateFeaturedType(Hotel $hotel,string $featuredType): Hotel;

    public function delete(Hotel $hotel): void;

    public function restore(int $id): Hotel;
}
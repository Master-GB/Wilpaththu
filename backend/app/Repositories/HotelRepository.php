<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Contracts\Repositories\HotelRepositoryInterface;

class HotelRepository implements HotelRepositoryInterface
{
    public function create(array $data): Hotel
    {
        return Hotel::create($data);
    }

    public function getAll()
    {
        return Hotel::with('owner')->latest()->get();
    }

    public function findById(int $id): ?Hotel
    {
        return Hotel::with('owner')->find($id);
    }

    public function findByOwner(int $userId): ?Hotel
    {
        return Hotel::with('owner')->where('user_id', $userId)->first();
    }

    public function findBySlug(string $slug): ?Hotel
    {
        return Hotel::with('owner')->where('slug', $slug)->first();
    }

    public function update(
        Hotel $hotel,
        array $data
    ): Hotel {
        $hotel->update($data);

        return $hotel->refresh();
    }

    public function updateStatus(
        Hotel $hotel,
        string $status
    ): Hotel {
        $hotel->update([
            'status' => $status,
        ]);

        return $hotel->refresh();
    }

    public function updateVerification(
        Hotel $hotel,
        bool $verified
    ): Hotel {
        $hotel->update([
            'verified' => $verified,
        ]);

        return $hotel->refresh();
    }

    public function updateStarRating(
        Hotel $hotel,
        ?int $starRating
    ): Hotel {
        $hotel->update([
            'star_rating' => $starRating,
        ]);

        return $hotel->refresh();
    }

    public function updateFeaturedType(
        Hotel $hotel,
        string $featuredType
    ): Hotel {
        $hotel->update([
            'featured_type' => $featuredType,
        ]);

        return $hotel->refresh();
    }

    public function delete(Hotel $hotel): void
    {
        $hotel->delete();
    }

    public function restore(int $id): Hotel
    {
        $hotel = Hotel::withTrashed()
            ->findOrFail($id);

        $hotel->restore();

        return $hotel->fresh();
    }
}
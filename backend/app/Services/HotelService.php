<?php

namespace App\Services;

use App\Models\Hotel;
use App\DTOs\StoreHotelData;
use Illuminate\Support\Str;
use App\DTOs\UpdateHotelData;
use Illuminate\Validation\ValidationException;
use App\Contracts\Services\HotelServiceInterface;
use App\DTOs\UpdateHotelStatusData;
use App\DTOs\UpdateHotelStarRatingData;
use App\DTOs\UpdateHotelFeaturedTypeData;
use App\DTOs\UpdateHotelVerificationData;
use App\Contracts\Repositories\HotelRepositoryInterface;

class HotelService implements HotelServiceInterface
{
    public function __construct(
        private readonly HotelRepositoryInterface $hotelRepository
    ) {}

    public function create(StoreHotelData $data): Hotel
    {
        $user = auth()->user();

        $this->ensureOwnerDoesNotHaveHotel($user->id);

        return $this->hotelRepository->create([
            'user_id' => $user->id,
            'hotel_name' => $data->hotel_name,
            'slug' => $this->generateUniqueSlug($data->hotel_name),
            'description' => $data->description,
            'address' => $data->address,
            'district' => $data->district,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'contact_number' => $data->contact_number,
            'email' => $data->email,
            'website' => $data->website,
            'amenities' => $data->amenities,
            'languages_spoken' => $data->languages_spoken,
            'nearby_attractions' => $data->nearby_attractions,
            'check_in_policy' => $data->check_in_policy,
            'check_out_policy' => $data->check_out_policy,
            'cancellation_policy' => $data->cancellation_policy,
        ]);
    }

    public function getAll()
    {
        return $this->hotelRepository->getAll();
    }

    public function findById(int $id): ?Hotel
    {
        return $this->hotelRepository->findById($id);
    }

    public function findByOwner(int $userId): ?Hotel
    {
        return $this->hotelRepository->findByOwner($userId);
    }

    public function findBySlug(string $slug): ?Hotel
    {
        return $this->hotelRepository->findBySlug($slug);
    }

    public function update(
        Hotel $hotel,
        UpdateHotelData $data
    ): Hotel {

        $updateData = [
            'hotel_name' => $data->hotel_name,
            'description' => $data->description,
            'address' => $data->address,
            'district' => $data->district,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'contact_number' => $data->contact_number,
            'website' => $data->website,
            'amenities' => $data->amenities,
            'languages_spoken' => $data->languages_spoken,
            'nearby_attractions' => $data->nearby_attractions,
            'check_in_policy' => $data->check_in_policy,
            'check_out_policy' => $data->check_out_policy,
            'cancellation_policy' => $data->cancellation_policy,
        ];

        if (
            $data->hotel_name &&
            $data->hotel_name !== $hotel->hotel_name
        ) {
            $updateData['slug'] = $this->generateUniqueSlug(
                $data->hotel_name
            );
        }

        return $this->hotelRepository->update(
            $hotel,
            array_filter(
                $updateData,
                fn($value) => $value !== null
            )
        );
    }

    public function updateStatus(
        Hotel $hotel,
        UpdateHotelStatusData $data
    ): Hotel {

        return $this->hotelRepository->updateStatus(
            $hotel,
            $data->status
        );
    }

    public function updateVerification(
        Hotel $hotel,
        UpdateHotelVerificationData $data
    ): Hotel {

        return $this->hotelRepository->updateVerification(
            $hotel,
            $data->verified
        );
    }

    public function updateStarRating(
        Hotel $hotel,
        UpdateHotelStarRatingData $data
    ): Hotel {

        return $this->hotelRepository->updateStarRating(
            $hotel,
            $data->star_rating
        );
    }

    public function updateFeaturedType(
        Hotel $hotel,
        UpdateHotelFeaturedTypeData $data
    ): Hotel {

        return $this->hotelRepository->updateFeaturedType(
            $hotel,
            $data->featured_type
        );
    }

    public function delete(Hotel $hotel): void
    {
        $this->hotelRepository->delete($hotel);
    }

    public function restore(int $id): Hotel
    {
        return $this->hotelRepository->restore($id);
    }

 

    private function ensureOwnerDoesNotHaveHotel(int $userId): void
    {
        if ($this->hotelRepository->findByOwner($userId)) {

            throw ValidationException::withMessages([
                'hotel' => [
                    'You have already registered a hotel.',
                ],
            ]);
        }
    }

    private function generateUniqueSlug(string $hotelName): string
    {
        $slug = Str::slug($hotelName);

        $originalSlug = $slug;

        $counter = 2;

        while (
            $this->hotelRepository->findBySlug($slug)
        ) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
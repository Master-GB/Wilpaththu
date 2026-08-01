<?php

namespace App\DTOs;

use App\Http\Requests\UpdateDriverRequest;

readonly class UpdateDriverData
{
    public function __construct(
        public ?string $phone,
        public ?string $license_number,
        public ?string $license_expiry_date,
        public ?int $experience_years,
        public ?array $languages,
        public ?string $emergency_contact,
    ) {}

    public static function fromRequest(
        UpdateDriverRequest $request
    ): self {

        return new self(

            name: $request->input('name'),
        
            phone: $request->input('phone'),

            license_number: $request->input('license_number'),

            license_expiry_date: $request->input('license_expiry_date'),

            experience_years: $request->input('experience_years'),

            languages: $request->input('languages'),

            emergency_contact: $request->input('emergency_contact'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'phone' => $this->phone,
            'license_number' => $this->license_number,
            'license_expiry_date' => $this->license_expiry_date,
            'experience_years' => $this->experience_years,
            'languages' => $this->languages,
            'emergency_contact' => $this->emergency_contact,
        ], fn ($value) => ! is_null($value));
    }
}
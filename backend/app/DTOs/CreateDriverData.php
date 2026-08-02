<?php

namespace App\DTOs;

use App\Http\Requests\CreateDriverRequest;

readonly class CreateDriverData
{
    public function __construct(

        public int $business_id,

        public string $name,

        public string $email,

        public string $phone,

        public string $license_number,

        public string $license_expiry_date,

        public int $experience_years,

        public ?array $languages,

        public ?string $emergency_contact,

    ) {}

    public static function fromRequest(
        CreateDriverRequest $request
    ): self {

        return new self(

            business_id: $request->business_id,

            name: $request->name,

            email: $request->email,

            phone: $request->phone,

            license_number: $request->license_number,

            license_expiry_date: $request->license_expiry_date,

            experience_years: $request->experience_years,

            languages: $request->languages,

            emergency_contact: $request->emergency_contact,

        );
    }
}
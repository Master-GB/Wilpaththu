<?php

namespace App\DTOs;

use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;

class BusinessData
{
    public function __construct(
        public readonly string $business_name,
        public readonly string $description,
        public readonly string $registration_number,
        public readonly string $business_type,
        public readonly string $contact_number,
        public readonly ?string $email,
        public readonly string $address,
    ) {}

    public static function fromRequest(
        StoreBusinessRequest|UpdateBusinessRequest $request
    ): self {
        return new self(
            business_name: $request->business_name,
            description: $request->description,
            registration_number: $request->registration_number,
            business_type: $request->business_type,
            contact_number: $request->contact_number,
            email: $request->email,
            address: $request->address,
        );
    }

    public function toArray(): array
    {
        return [
            'business_name' => $this->business_name,
            'registration_number' => $this->registration_number,
            'business_type' => $this->business_type,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'address' => $this->address,
        ];
    }
}

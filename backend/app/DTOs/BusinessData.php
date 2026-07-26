<?php

namespace App\DTOs;

use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;

class BusinessData
{
   public function __construct(
        public readonly ?string $business_name = null,
        public readonly ?string $description = null,
        public readonly ?string $registration_number = null,
        public readonly ?string $business_type = null,
        public readonly ?string $contact_number = null,
        public readonly ?string $email = null,
        public readonly ?string $address = null,

    ) {}


    public static function fromRequest(
        StoreBusinessRequest|UpdateBusinessRequest $request
    ): self {
        return new self(
            business_name: $request->input('business_name'),
            description: $request->input('description'),
            registration_number: $request->input('registration_number'),
            business_type: $request->input('business_type'),
            contact_number: $request->input('contact_number'),
            email: $request->input('email'),
            address: $request->input('address'),
        );
    }

    public function toArray(): array
    {
         return array_filter([
            'business_name' => $this->business_name,
            'description' => $this->description,
            'registration_number' => $this->registration_number,
            'business_type' => $this->business_type,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'address' => $this->address,
        ], fn ($value) => $value !== null);

    }
}

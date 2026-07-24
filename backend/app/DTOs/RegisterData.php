<?php

namespace App\DTOs;

use App\Http\Requests\RegisterRequest;

class RegisterData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $role,
    ) {}

    public static function fromRequest ( RegisterRequest $request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: bcrypt($request->password),
            role: $request->role,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

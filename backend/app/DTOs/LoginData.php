<?php

namespace App\DTOs;

use App\Http\Requests\LoginRequest;

class LoginData extends BaseData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }
}

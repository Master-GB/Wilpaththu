<?php

namespace App\DTOs;

use App\Models\User;

class AuthResultData extends BaseData
{
    public function __construct(
        public readonly User $user,
        public readonly string $token,
    ) {}
}

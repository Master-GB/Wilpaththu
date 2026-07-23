<?php

namespace App\Contracts\Services;

use App\DTOs\AuthResultData;
use App\DTOs\LoginData;
use App\DTOs\RegisterData;
use App\Models\User;

interface AuthServiceInterface
{
    public function register(RegisterData $data): AuthResultData;

    public function login(LoginData $data): AuthResultData;

    public function logout(User $user): void;
}

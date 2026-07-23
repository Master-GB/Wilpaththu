<?php

namespace App\Contracts\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

interface AuthServiceInterface
{
    public function register(RegisterRequest $request);

    public function login(LoginRequest $request);

    public function logout();

    public function user();
}

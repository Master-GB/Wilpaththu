<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\LoginData;
use App\DTOs\RegisterData;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(
            RegisterData::fromRequest($request)
        );

        return $this->success(
            [
                'user' => new UserResource($result->user),
                'token' => $result->token,
            ],
            'User registered successfully.',
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            LoginData::fromRequest($request)
        );

        return $this->success(
            [
                'user' => new UserResource($result->user),
                'token' => $result->token,
            ],
            'Login successful.'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->success(
            null,
            'Logout successful.'
        );
    }

    public function user(Request $request): JsonResponse
    {
        return $this->success(
            new UserResource($request->user()),
            'Authenticated user retrieved successfully.'
        );
    }
}

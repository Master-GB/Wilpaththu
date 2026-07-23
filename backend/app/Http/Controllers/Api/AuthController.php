<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\AuthServiceInterface;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request);

        return $this->success(
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'User registered successfully.',
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request);

        return $this->success(
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'Login successful.'
        );
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->success(
            null,
            'Logout successful.'
        );
    }

    public function user(): JsonResponse
    {
        return $this->success(
            new UserResource(
                $this->authService->user()
            )
        );
    }
}

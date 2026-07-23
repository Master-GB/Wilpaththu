<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->login($request)
        );
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Logout successful.'
        ]);
    }

    public function user(): JsonResponse
    {
        return response()->json(
            $this->authService->user()
        );
    }
}

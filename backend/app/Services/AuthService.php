<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {}

    public function register(RegisterRequest $request)
    {
        $user = $this->users->create($request->validated());

        $user->assignRole('Tourist');

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->validated())) {
            abort(401, 'Invalid email or password.');
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
    }

    public function user()
    {
        return request()->user();
    }
}

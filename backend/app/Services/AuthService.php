<?php

namespace App\Services;

use Laravel\Sanctum\PersonalAccessToken;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\AuthResultData;
use App\DTOs\LoginData;
use App\DTOs\RegisterData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    /**
     * Register a new user.
     */
    public function register(RegisterData $data): AuthResultData
    {
        $user = $this->users->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);

        // Assign default role
        $user->assignRole('Tourist');

        // Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthResultData(
            user: $user,
            token: $token
        );
    }

    /**
     * Login existing user.
     */
    public function login(LoginData $data): AuthResultData
    {
        if (! Auth::attempt([
            'email' => $data->email,
            'password' => $data->password,
        ])) {
            throw new AuthenticationException('Invalid email or password.');
        }

        /** @var User $user */
        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthResultData(
            user: $user,
            token: $token
        );
    }

   public function logout(User $user): void
{
    $token = $user->currentAccessToken();

    if ($token instanceof PersonalAccessToken) {
        $token->delete();
    }
}
}

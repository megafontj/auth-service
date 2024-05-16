<?php

namespace App\Services;

use App\DTO\LoginDto;
use App\Jobs\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): User
    {
        $user = User::create($data);

        UserRegistered::dispatch(array_merge($data, $user->toArray()))->onQueue('user-registered');

        return $user;
    }

    public function login(LoginDto $loginDto): array
    {
        /** @var User $user */
        $user = User::whereEmail($loginDto->email)->first();

        if (! $user || !Hash::check($loginDto->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'Wrong password or email'
            ]);
        }

        return ['token' => $user->createToken('authToken')->plainTextToken];
    }

    public function logout(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
    }
}

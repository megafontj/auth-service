<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Support\Resources\EmptyResource;

class AuthController extends Controller
{
    public function __construct(readonly private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): UserResource
    {
        return new UserResource($this->authService->register($request->validated()));
    }

    public function login(LoginRequest $request)
    {
        return new TokenResource((object)$this->authService->login($request->covertToDto()));
    }

    public function logout(): EmptyResource
    {
        $this->authService->logout();
        return new EmptyResource();
    }
}

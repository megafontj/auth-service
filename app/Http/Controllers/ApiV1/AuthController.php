<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use App\Support\Resources\EmptyResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(readonly private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): AuthResource
    {
        return new AuthResource($this->authService->register($request->validated()));
    }

    public function login(LoginRequest $request): TokenResource
    {
        return new TokenResource((object)$this->authService->login($request->covertToDto()));
    }

    public function logout(): EmptyResource
    {
        $this->authService->logout();
        return new EmptyResource();
    }

    public function current(): AuthResource
    {
        return new AuthResource(Auth::user());
    }
}

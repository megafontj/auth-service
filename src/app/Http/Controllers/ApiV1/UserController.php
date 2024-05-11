<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Support\QuerySearch\SearchQuery;
use App\Support\Resources\EmptyResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(readonly private UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchQuery $filter)
    {
        print_r(Auth::user());
        exit;
        return User::filter($filter)->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateOrCreateUserRequest $request): UserResource
    {
        return new UserResource($this->userService->upsert($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrCreateUserRequest $request, User $user): UserResource
    {
        return new UserResource($this->userService->upsert($request->validated(), $user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): EmptyResource
    {
        $this->userService->destroy($user);
        return new EmptyResource();
    }
}

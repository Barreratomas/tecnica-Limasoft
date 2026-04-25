<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $role  = $request->query('role');
        $users = $this->userService->getUsers($role);

        return response()->json($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = $this->userService->createUser($request->validated());

        return response()->json($user, 201);
    }

    public function show(int $id): JsonResponse
    {
        $this->authorize('view', User::class);

        $user = $this->userService->getUser($id);

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', User::class);

        $user = $this->userService->updateUser($id, $request->validated());

        return response()->json($user);
    }
}
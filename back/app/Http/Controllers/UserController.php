<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    #[OA\Get(
        path: "/api/users",
        summary: "Listar usuarios",
        tags: ["Users"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "role", in: "query", required: false, schema: new OA\Schema(type: "string", enum: ["admin", "teacher", "student"])),
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista de usuarios", content: new OA\JsonContent(
                type: "array",
                items: new OA\Items(properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "email", type: "string"),
                    new OA\Property(property: "role", type: "string"),
                ])
            )),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $role  = $request->query('role');
        $users = $this->userService->getUsers($role);

        return response()->json($users);
    }

    #[OA\Post(
        path: "/api/users",
        summary: "Crear usuario",
        tags: ["Users"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ["name", "email", "password", "role"],
            properties: [
                new OA\Property(property: "name", type: "string"),
                new OA\Property(property: "email", type: "string", format: "email"),
                new OA\Property(property: "password", type: "string"),
                new OA\Property(property: "role", type: "string", enum: ["admin", "teacher", "student"]),
            ]
        )),
        responses: [
            new OA\Response(response: 201, description: "Usuario creado"),
            new OA\Response(response: 422, description: "Validación fallida"),
        ]
    )]
    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = $this->userService->createUser($request->validated());

        return response()->json($user, 201);
    }

    #[OA\Get(
        path: "/api/users/{id}",
        summary: "Mostrar usuario",
        tags: ["Users"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Usuario", content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "email", type: "string"),
                    new OA\Property(property: "role", type: "string"),
                ]
            )),
            new OA\Response(response: 404, description: "No encontrado"),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUser($id);

        if (! $user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $this->authorize('view', $user);

        return response()->json($user);
    }

    #[OA\Put(
        path: "/api/users/{id}",
        summary: "Actualizar usuario",
        tags: ["Users"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string"),
                new OA\Property(property: "email", type: "string", format: "email"),
                new OA\Property(property: "password", type: "string", nullable: true),
                new OA\Property(property: "role", type: "string", enum: ["admin", "teacher", "student"]),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: "Usuario actualizado"),
            new OA\Response(response: 404, description: "No encontrado"),
        ]
    )]
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        
        $user = $this->userService->getUser($id);

        if (! $user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $this->authorize('update', $user);

        $updated = $this->userService->updateUser($id, $request->validated());

        return response()->json($updated);
    }
}
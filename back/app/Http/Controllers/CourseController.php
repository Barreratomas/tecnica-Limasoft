<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use App\Services\CourseService;
use OpenApi\Attributes as OA;


class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}

    #[OA\Get(
        path: "/api/courses",
        summary: "Listar cursos",
        tags: ["Courses"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de cursos",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer"),
                            new OA\Property(property: "name", type: "string"),
                            new OA\Property(property: "description", type: "string", nullable: true),
                            new OA\Property(property: "teacher_id", type: "integer"),
                        ]
                    )
                )
            )
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $courses = $this->courseService->getCoursesForUser($request->user());

        return response()->json($courses);
    }

    #[OA\Post(
        path: "/api/courses",
        summary: "Crear curso",
        tags: ["Courses"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "teacher_id"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string", nullable: true),
                    new OA\Property(property: "teacher_id", type: "integer"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Curso creado"),
            new OA\Response(response: 422, description: "Validación fallida"),
        ]
    )]
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $this->authorize('create', Course::class);

        $course = $this->courseService->createCourse($request->validated());

        return response()->json($course, 201);
    }

    #[OA\Get(
        path: "/api/courses/{id}",
        summary: "Mostrar curso",
        tags: ["Courses"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Curso", content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string", nullable: true),
                    new OA\Property(property: "teacher_id", type: "integer"),
                ]
            )),
            new OA\Response(response: 404, description: "No encontrado"),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        $this->authorize('view', $course);

        return response()->json($course);
    }

    #[OA\Put(
        path: "/api/courses/{id}",
        summary: "Actualizar curso",
        tags: ["Courses"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string", nullable: true),
                    new OA\Property(property: "teacher_id", type: "integer"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Curso actualizado"),
            new OA\Response(response: 404, description: "No encontrado"),
        ]
    )]
    public function update(UpdateCourseRequest $request, int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        $this->authorize('update', $course);

        $updated = $this->courseService->updateCourse($id, $request->validated());

        return response()->json($updated);
    }

    #[OA\Delete(
        path: "/api/courses/{id}",
        summary: "Eliminar curso",
        tags: ["Courses"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Curso eliminado"),
            new OA\Response(response: 404, description: "No encontrado"),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        $this->authorize('delete', $course);

        $this->courseService->deleteCourse($id);

        return response()->json(['message' => 'Curso eliminado correctamente.']);
    }
}
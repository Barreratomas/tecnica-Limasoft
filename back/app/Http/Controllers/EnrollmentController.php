<?php

namespace App\Http\Controllers;

use App\Services\EnrollmentService;
use App\Services\CourseService;
use App\Http\Requests\Enrollment\EnrollStudentRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class EnrollmentController extends Controller
{
    public function __construct(
        private EnrollmentService $enrollmentService,
        private CourseService $courseService
    ) {}

    #[OA\Get(
        path: "/api/courses/{course}/students",
        summary: "Listar estudiantes de un curso",
        tags: ["Enrollments"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "course", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista de estudiantes", content: new OA\JsonContent(
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
    public function students(int $courseId): JsonResponse
    {
        $course = $this->courseService->getCourse($courseId);

        $this->authorize('viewStudents', $course);

        $students = $this->enrollmentService->getStudentsByCourse($courseId);

        return response()->json($students);
    }

    #[OA\Post(
        path: "/api/courses/{course}/enroll",
        summary: "Matricular estudiante en curso",
        tags: ["Enrollments"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "course", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ["student_id"],
            properties: [
                new OA\Property(property: "student_id", type: "integer"),
            ]
        )),
        responses: [
            new OA\Response(response: 201, description: "Matrícula creada"),
            new OA\Response(response: 422, description: "Validación fallida"),
        ]
    )]
    public function enroll(EnrollStudentRequest $request, int $courseId): JsonResponse
    {
        $this->authorize('enroll', Course::class);

        $enrollment = $this->enrollmentService->enroll(
            $courseId,
            $request->validated()['student_id']
        );

        return response()->json($enrollment, 201);
    }

    #[OA\Delete(
        path: "/api/enrollments/{enrollment}",
        summary: "Eliminar matrícula",
        tags: ["Enrollments"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "enrollment", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Matrícula eliminada"),
            new OA\Response(response: 404, description: "No encontrada"),
        ]
    )]
    public function destroy(int $enrollmentId): JsonResponse
    {
        $this->authorize('create', Course::class);

        $this->enrollmentService->unenroll($enrollmentId);

        return response()->json(['message' => 'Matrícula eliminada correctamente.']);
    }
}
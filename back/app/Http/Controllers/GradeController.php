<?php

namespace App\Http\Controllers;

use App\Services\GradeService;
use App\Services\EnrollmentService;
use App\Http\Requests\Grade\UpdateGradeRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class GradeController extends Controller
{
    public function __construct(
        private GradeService $gradeService,
        private EnrollmentService $enrollmentService
    ) {}

    #[OA\Get(
        path: "/api/enrollments/{enrollment}/grade",
        summary: "Mostrar nota de una matrícula",
        tags: ["Grades"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "enrollment", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Nota", content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "value", type: "number", format: "float"),
                    new OA\Property(property: "notes", type: "string", nullable: true),
                ]
            )),
            new OA\Response(response: 404, description: "Sin nota asignada"),
        ]
    )]
    public function show(int $enrollmentId): JsonResponse
    {
        $enrollment = $this->enrollmentService->getEnrollment($enrollmentId);

        $this->authorize('view', $enrollment);

        $grade = $this->gradeService->getGrade($enrollmentId);

        if (!$grade) {
            return response()->json(['message' => 'Sin nota asignada aún.'], 404);
        }

        return response()->json($grade);
    }

    #[OA\Put(
        path: "/api/enrollments/{enrollment}/grade",
        summary: "Actualizar nota",
        tags: ["Grades"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "enrollment", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ["value"],
            properties: [
                new OA\Property(property: "value", type: "number", format: "float", example: 7.5),
                new OA\Property(property: "notes", type: "string", nullable: true),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: "Nota actualizada"),
            new OA\Response(response: 404, description: "Matrícula no encontrada"),
        ]
    )]
    public function update(UpdateGradeRequest $request, int $enrollmentId): JsonResponse
    {
        $enrollment = $this->enrollmentService->getEnrollment($enrollmentId);

        $this->authorize('update', $enrollment);

        $grade = $this->gradeService->updateGrade(
            $enrollmentId,
            $request->validated(),
            $request->user()->id
        );

        return response()->json($grade);
    }
}
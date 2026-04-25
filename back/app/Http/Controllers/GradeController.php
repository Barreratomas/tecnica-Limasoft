<?php

namespace App\Http\Controllers;

use App\Services\GradeService;
use App\Services\EnrollmentService;
use App\Http\Requests\Grade\UpdateGradeRequest;
use Illuminate\Http\JsonResponse;

class GradeController extends Controller
{
    public function __construct(
        private GradeService $gradeService,
        private EnrollmentService $enrollmentService
    ) {}

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
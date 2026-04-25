<?php

namespace App\Http\Controllers;

use App\Services\EnrollmentService;
use App\Services\CourseService;
use App\Http\Requests\Enrollment\EnrollStudentRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    public function __construct(
        private EnrollmentService $enrollmentService,
        private CourseService $courseService
    ) {}

    public function students(int $courseId): JsonResponse
    {
        $course = $this->courseService->getCourse($courseId);

        $this->authorize('viewStudents', $course);

        $students = $this->enrollmentService->getStudentsByCourse($courseId);

        return response()->json($students);
    }

    public function enroll(EnrollStudentRequest $request, int $courseId): JsonResponse
    {
        $this->authorize('enroll', Course::class);

        $enrollment = $this->enrollmentService->enroll(
            $courseId,
            $request->validated()['student_id']
        );

        return response()->json($enrollment, 201);
    }

    public function destroy(int $enrollmentId): JsonResponse
    {
        $this->authorize('create', Course::class);

        $this->enrollmentService->unenroll($enrollmentId);

        return response()->json(['message' => 'Matrícula eliminada correctamente.']);
    }
}
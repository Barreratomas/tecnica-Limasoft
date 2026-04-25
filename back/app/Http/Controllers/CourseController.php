<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use App\Services\CourseService;


class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $courses = $this->courseService->getCoursesForUser($request->user());

        return response()->json($courses);
    }

    public function store(StoreCourseRequest $request): JsonResponse
    {
        $this->authorize('create', Course::class);

        $course = $this->courseService->createCourse($request->validated());

        return response()->json($course, 201);
    }

    public function show(int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        $this->authorize('view', $course);

        return response()->json($course);
    }

    public function update(UpdateCourseRequest $request, int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        $this->authorize('update', $course);

        $updated = $this->courseService->updateCourse($id, $request->validated());

        return response()->json($updated);
    }

    public function destroy(int $id): JsonResponse
    {
        $course = $this->courseService->getCourse($id);

        $this->authorize('delete', $course);

        $this->courseService->deleteCourse($id);

        return response()->json(['message' => 'Curso eliminado correctamente.']);
    }
}
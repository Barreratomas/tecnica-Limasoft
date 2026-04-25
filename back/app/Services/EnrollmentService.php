<?php

namespace App\Services;

use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class EnrollmentService
{
    public function __construct(
        private EnrollmentRepositoryInterface $enrollmentRepository
    ) {}

    public function getStudentsByCourse(int $courseId): Collection
    {
        return $this->enrollmentRepository->findByCourse($courseId);
    }

    public function enroll(int $courseId, int $studentId): Enrollment
    {
        $existing = $this->enrollmentRepository
            ->findByCourse($courseId)
            ->where('student_id', $studentId)
            ->first();

        if ($existing) {
            throw ValidationException::withMessages([
                'student_id' => ['El alumno ya está matriculado en este curso.'],
            ]);
        }

        return $this->enrollmentRepository->create([
            'course_id'   => $courseId,
            'student_id'  => $studentId,
            'enrolled_at' => now(),
        ]);
    }

    public function getEnrollment(int $id): Enrollment
    {
        $enrollment = $this->enrollmentRepository->findById($id);

        if (!$enrollment) {
            abort(404, 'Matrícula no encontrada.');
        }

        return $enrollment;
    }

    public function unenroll(int $enrollmentId): void
    {
        $this->enrollmentRepository->delete($enrollmentId);
    }
}
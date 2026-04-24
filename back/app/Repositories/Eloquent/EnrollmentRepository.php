<?php

namespace App\Repositories\Eloquent;

use App\Models\Enrollment;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function findByCourse(int $courseId): Collection
    {
        return Enrollment::with('student', 'grade')
                         ->where('course_id', $courseId)
                         ->get();
    }

    public function findByStudent(int $studentId): Collection
    {
        return Enrollment::with('course', 'grade')
                         ->where('student_id', $studentId)
                         ->get();
    }

    public function findById(int $id): ?Enrollment
    {
        return Enrollment::with('student', 'course', 'grade')
                         ->find($id);
    }

    public function create(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    public function delete(int $id): void
    {
        Enrollment::findOrFail($id)->delete();
    }
}
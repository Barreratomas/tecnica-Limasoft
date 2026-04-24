<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository implements CourseRepositoryInterface
{
    public function findAll(): Collection
    {
        return Course::with('teacher')->get();
    }

    public function findByTeacher(int $teacherId): Collection
    {
        return Course::with('teacher')
                     ->where('teacher_id', $teacherId)
                     ->get();
    }

    public function findByStudent(int $studentId): Collection
    {
        return Course::with('teacher')
                     ->whereHas('enrollments', function ($q) use ($studentId) {
                         $q->where('student_id', $studentId);
                     })
                     ->get();
    }

    public function findById(int $id): ?Course
    {
        return Course::with('teacher', 'enrollments.student', 'enrollments.grade')
                     ->find($id);
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(int $id, array $data): Course
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course->fresh();
    }

    public function delete(int $id): void
    {
        Course::findOrFail($id)->delete();
    }
}
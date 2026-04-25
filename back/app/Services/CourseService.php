<?php

namespace App\Services;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    public function __construct(
        private CourseRepositoryInterface $courseRepository
    ) {}

    public function getCoursesForUser($user): Collection
    {
        if ($user->hasRole('admin')) {
            return $this->courseRepository->findAll();
        }

        if ($user->hasRole('teacher')) {
            return $this->courseRepository->findByTeacher($user->id);
        }

        return $this->courseRepository->findByStudent($user->id);
    }

    public function getCourse(int $id): ?Course
    {
        return $this->courseRepository->findById($id);
    }

    public function createCourse(array $data): Course
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse(int $id, array $data): Course
    {
        return $this->courseRepository->update($id, $data);
    }

    public function deleteCourse(int $id): void
    {
        $this->courseRepository->delete($id);
    }
}
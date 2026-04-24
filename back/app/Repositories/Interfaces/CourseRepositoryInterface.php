<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    public function findAll(): Collection;
    public function findByTeacher(int $teacherId): Collection;
    public function findByStudent(int $studentId): Collection;
    public function findById(int $id): ?Course;
    public function create(array $data): Course;
    public function update(int $id, array $data): Course;
    public function delete(int $id): void;
}
<?php

namespace App\Repositories\Interfaces;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;

interface EnrollmentRepositoryInterface
{
    public function findByCourse(int $courseId): Collection;
    public function findByStudent(int $studentId): Collection;
    public function findById(int $id): ?Enrollment;
    public function create(array $data): Enrollment;
    public function delete(int $id): void;
}
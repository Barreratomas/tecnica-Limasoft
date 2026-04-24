<?php

namespace App\Repositories\Interfaces;

use App\Models\Grade;

interface GradeRepositoryInterface
{
    public function findByEnrollment(int $enrollmentId): ?Grade;
    public function updateOrCreate(int $enrollmentId, array $data): Grade;
}
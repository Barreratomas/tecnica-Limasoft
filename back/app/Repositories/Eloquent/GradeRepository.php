<?php

namespace App\Repositories\Eloquent;

use App\Models\Grade;
use App\Repositories\Interfaces\GradeRepositoryInterface;

class GradeRepository implements GradeRepositoryInterface
{
    public function findByEnrollment(int $enrollmentId): ?Grade
    {
        return Grade::where('enrollment_id', $enrollmentId)->first();
    }

    public function updateOrCreate(int $enrollmentId, array $data): Grade
    {
        return Grade::updateOrCreate(
            ['enrollment_id' => $enrollmentId],
            $data
        );
    }
}
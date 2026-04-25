<?php

namespace App\Services;

use App\Repositories\Interfaces\GradeRepositoryInterface;
use App\Models\Grade;

class GradeService
{
    public function __construct(
        private GradeRepositoryInterface $gradeRepository
    ) {}

    public function getGrade(int $enrollmentId): ?Grade
    {
        return $this->gradeRepository->findByEnrollment($enrollmentId);
    }

    public function updateGrade(int $enrollmentId, array $data, int $updatedBy): Grade
    {
        return $this->gradeRepository->updateOrCreate($enrollmentId, [
            'value'      => $data['value'],
            'notes'      => $data['notes'] ?? null,
            'updated_by' => $updatedBy,
        ]);
    }
}
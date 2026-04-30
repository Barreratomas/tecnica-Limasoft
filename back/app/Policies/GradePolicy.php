<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;
use App\Models\Enrollment;

/**
 * Política de autorización para calificaciones (Grade)
 * Define quién puede ver y actualizar las notas de los estudiantes
 */
class GradePolicy
{
    // Admin ve todas; teacher ve su curso; student ve la suya
    public function view(User $user, Enrollment $enrollment): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('teacher')) {
            return $enrollment->course->teacher_id === $user->id;
        }

        if ($user->hasRole('student')) {
            return $enrollment->student_id === $user->id;
        }

        return false;
    }

    // Solo el teacher del curso puede actualizar notas
    public function update(User $user, Enrollment $enrollment): bool
    {
        if ($user->hasRole('teacher')) {
            return $enrollment->course->teacher_id === $user->id;
        }

        return false;
    }
}
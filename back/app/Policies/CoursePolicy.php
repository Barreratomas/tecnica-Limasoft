<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

/**
 * Política de autorización para el modelo Course
 * Define quién puede ver, crear, actualizar o eliminar cursos
 */
class CoursePolicy
{
    // Admin y cualquier usuario pueden listar cursos
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Admin puede ver cualquier curso; teacher solo sus cursos; student solo inscrito
    public function view(User $user, Course $course): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('teacher')) {
            return $course->teacher_id === $user->id;
        }

        if ($user->hasRole('student')) {
            return $course->enrollments->contains('student_id', $user->id);
        }

        return false;
    }

    // Solo admin puede crear cursos
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // Solo admin puede actualizar cursos
    public function update(User $user, Course $course): bool
    {
        return $user->hasRole('admin');
    }

    // Solo admin puede eliminar cursos
    public function delete(User $user, Course $course): bool
    {
        return $user->hasRole('admin');
    }

    // Admin y teacher del curso pueden ver sus estudiantes
    public function viewStudents(User $user, Course $course): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('teacher')) {
            return $course->teacher_id === $user->id;
        }

        return false;
    }

    // Solo admin puede matricular estudiantes
    public function enroll(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
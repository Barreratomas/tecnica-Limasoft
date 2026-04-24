<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;
use App\Models\Enrollment;

class GradePolicy
{
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

    public function update(User $user, Enrollment $enrollment): bool
    {
        if ($user->hasRole('teacher')) {
            return $enrollment->course->teacher_id === $user->id;
        }

        return false;
    }
}
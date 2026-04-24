<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

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

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Course $course): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->hasRole('admin');
    }

    public function viewStudents(User $user, Course $course): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('teacher')) {
            return $course->teacher_id === $user->id;
        }

        return false;
    }

    public function enroll(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    public function test_admin_puede_matricular_alumno(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');
        $student = User::factory()->create();
        $student->assignRole('student');
        $course = Course::create(['name' => 'Curso A', 'teacher_id' => $teacher->id]);

        $response = $this->withToken($admin->createToken('test')->plainTextToken)
                         ->postJson("/api/courses/{$course->id}/enroll", [
                             'student_id' => $student->id,
                         ]);

        $response->assertStatus(201);
    }

    public function test_matricular_alumno_duplicado_devuelve_422(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');
        $student = User::factory()->create();
        $student->assignRole('student');
        $course = Course::create(['name' => 'Curso A', 'teacher_id' => $teacher->id]);

        Enrollment::create([
            'student_id'  => $student->id,
            'course_id'   => $course->id,
            'enrolled_at' => now(),
        ]);

        $response = $this->withToken($admin->createToken('test')->plainTextToken)
                         ->postJson("/api/courses/{$course->id}/enroll", [
                             'student_id' => $student->id,
                         ]);

        $response->assertStatus(422);
    }

    public function test_profesor_no_puede_matricular(): void
    {
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');
        $student = User::factory()->create();
        $student->assignRole('student');
        $course = Course::create(['name' => 'Curso A', 'teacher_id' => $teacher->id]);

        $response = $this->withToken($teacher->createToken('test')->plainTextToken)
                         ->postJson("/api/courses/{$course->id}/enroll", [
                             'student_id' => $student->id,
                         ]);

        $response->assertStatus(403);
    }
}
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    public function test_admin_puede_crear_curso(): void
    {
        $admin   = User::factory()->create(['password' => Hash::make('password')]);
        $admin->assignRole('admin');
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');

        $response = $this->withToken($admin->createToken('test')->plainTextToken)
                         ->postJson('/api/courses', [
                             'name'       => 'Matemáticas',
                             'teacher_id' => $teacher->id,
                         ]);

        $response->assertStatus(201);
    }

    public function test_profesor_no_puede_crear_curso(): void
    {
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');
        $otherTeacher = User::factory()->create();
        $otherTeacher->assignRole('teacher');

        $response = $this->withToken($teacher->createToken('test')->plainTextToken)
                         ->postJson('/api/courses', [
                             'name'       => 'Historia',
                             'teacher_id' => $otherTeacher->id,
                         ]);

        $response->assertStatus(403);
    }

    public function test_profesor_ve_solo_sus_cursos(): void
    {
        $teacher1 = User::factory()->create();
        $teacher1->assignRole('teacher');
        $teacher2 = User::factory()->create();
        $teacher2->assignRole('teacher');

        Course::create(['name' => 'Curso A', 'teacher_id' => $teacher1->id]);
        Course::create(['name' => 'Curso B', 'teacher_id' => $teacher2->id]);

        $response = $this->withToken($teacher1->createToken('test')->plainTextToken)
                         ->getJson('/api/courses');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_alumno_ve_solo_sus_cursos(): void
    {
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');
        $student = User::factory()->create();
        $student->assignRole('student');

        $course1 = Course::create(['name' => 'Curso A', 'teacher_id' => $teacher->id]);
        Course::create(['name' => 'Curso B', 'teacher_id' => $teacher->id]);

        \App\Models\Enrollment::create([
            'student_id'  => $student->id,
            'course_id'   => $course1->id,
            'enrolled_at' => now(),
        ]);

        $response = $this->withToken($student->createToken('test')->plainTextToken)
                         ->getJson('/api/courses');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
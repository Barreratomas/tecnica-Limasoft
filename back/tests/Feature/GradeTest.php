<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    private function createEnrollmentWithGrade(): array
    {
        $teacher = User::factory()->create();
        $teacher->assignRole('teacher');
        $student = User::factory()->create();
        $student->assignRole('student');
        $course = Course::create(['name' => 'Curso A', 'teacher_id' => $teacher->id]);
        $enrollment = Enrollment::create([
            'student_id'  => $student->id,
            'course_id'   => $course->id,
            'enrolled_at' => now(),
        ]);
        $grade = Grade::create([
            'enrollment_id' => $enrollment->id,
            'value'         => 8.50,
            'updated_by'    => $teacher->id,
        ]);

        return compact('teacher', 'student', 'course', 'enrollment', 'grade');
    }

    public function test_alumno_puede_ver_su_nota(): void
    {
        ['student' => $student, 'enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $response = $this->withToken($student->createToken('test')->plainTextToken)
                         ->getJson("/api/enrollments/{$enrollment->id}/grade");

        $response->assertStatus(200);
    }

    public function test_alumno_no_puede_ver_nota_de_otro(): void
    {
        ['enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $otherStudent = User::factory()->create();
        $otherStudent->assignRole('student');

        $response = $this->withToken($otherStudent->createToken('test')->plainTextToken)
                         ->getJson("/api/enrollments/{$enrollment->id}/grade");

        $response->assertStatus(403);
    }

    public function test_profesor_puede_ver_notas_de_sus_alumnos(): void
    {
        ['teacher' => $teacher, 'enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $response = $this->withToken($teacher->createToken('test')->plainTextToken)
                         ->getJson("/api/enrollments/{$enrollment->id}/grade");

        $response->assertStatus(200);
    }

    public function test_profesor_no_puede_ver_nota_de_otro_curso(): void
    {
        ['enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $otherTeacher = User::factory()->create();
        $otherTeacher->assignRole('teacher');

        $response = $this->withToken($otherTeacher->createToken('test')->plainTextToken)
                         ->getJson("/api/enrollments/{$enrollment->id}/grade");

        $response->assertStatus(403);
    }

    public function test_profesor_puede_actualizar_nota_de_su_alumno(): void
    {
        ['teacher' => $teacher, 'enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $response = $this->withToken($teacher->createToken('test')->plainTextToken)
                         ->putJson("/api/enrollments/{$enrollment->id}/grade", [
                             'value' => 9.00,
                             'notes' => 'Excelente.',
                         ]);

        $response->assertStatus(200);
    }

    public function test_profesor_no_puede_actualizar_nota_de_alumno_ajeno(): void
    {
        ['enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $otherTeacher = User::factory()->create();
        $otherTeacher->assignRole('teacher');

        $response = $this->withToken($otherTeacher->createToken('test')->plainTextToken)
                         ->putJson("/api/enrollments/{$enrollment->id}/grade", [
                             'value' => 5.00,
                         ]);

        $response->assertStatus(403);
    }

    public function test_admin_puede_ver_cualquier_nota(): void
    {
        ['enrollment' => $enrollment] = $this->createEnrollmentWithGrade();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->withToken($admin->createToken('test')->plainTextToken)
                         ->getJson("/api/enrollments/{$enrollment->id}/grade");

        $response->assertStatus(200);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $perez     = User::where('email', 'perez@demo.com')->first();
        $martinez  = User::where('email', 'martinez@demo.com')->first();
        $rodriguez = User::where('email', 'rodriguez@demo.com')->first();
        $gomez     = User::where('email', 'gomez@demo.com')->first();

        $matematicas  = Course::where('name', 'Matemáticas')->first();
        $historia     = Course::where('name', 'Historia')->first();
        $programacion = Course::where('name', 'Programación')->first();

        $enrollments = [
            ['student_id' => $perez->id,     'course_id' => $matematicas->id],
            ['student_id' => $perez->id,     'course_id' => $programacion->id],
            ['student_id' => $martinez->id,  'course_id' => $matematicas->id],
            ['student_id' => $martinez->id,  'course_id' => $historia->id],
            ['student_id' => $rodriguez->id, 'course_id' => $historia->id],
            ['student_id' => $rodriguez->id, 'course_id' => $programacion->id],
            ['student_id' => $gomez->id,     'course_id' => $matematicas->id],
            ['student_id' => $gomez->id,     'course_id' => $programacion->id],
        ];

        foreach ($enrollments as $enrollment) {
            Enrollment::create([
                ...$enrollment,
                'enrolled_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher1 = User::where('email', 'garcia@demo.com')->first();
        $teacher2 = User::where('email', 'lopez@demo.com')->first();

        Course::create([
            'name'        => 'Matemáticas',
            'description' => 'Álgebra y cálculo básico.',
            'teacher_id'  => $teacher1->id,
        ]);

        Course::create([
            'name'        => 'Historia',
            'description' => 'Historia moderna y contemporánea.',
            'teacher_id'  => $teacher1->id,
        ]);

        Course::create([
            'name'        => 'Programación',
            'description' => 'Fundamentos de programación orientada a objetos.',
            'teacher_id'  => $teacher2->id,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin Principal',
            'email'    => 'admin@demo.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $teacher1 = User::create([
            'name'     => 'Profesor García',
            'email'    => 'garcia@demo.com',
            'password' => Hash::make('password'),
        ]);
        $teacher1->assignRole('teacher');

        $teacher2 = User::create([
            'name'     => 'Profesora López',
            'email'    => 'lopez@demo.com',
            'password' => Hash::make('password'),
        ]);
        $teacher2->assignRole('teacher');

        $students = [
            ['name' => 'Alumno Pérez',    'email' => 'perez@demo.com'],
            ['name' => 'Alumna Martínez', 'email' => 'martinez@demo.com'],
            ['name' => 'Alumno Rodríguez','email' => 'rodriguez@demo.com'],
            ['name' => 'Alumna Gómez',    'email' => 'gomez@demo.com'],
        ];

        foreach ($students as $student) {
            $user = User::create([
                'name'     => $student['name'],
                'email'    => $student['email'],
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('student');
        }
    }
}

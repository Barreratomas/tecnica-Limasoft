<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\User;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $teacher1 = User::where('email', 'garcia@demo.com')->first();
        $teacher2 = User::where('email', 'lopez@demo.com')->first();

       
        $grades = [
            ['enrollment_id' => 1, 'value' => 8.50, 'updated_by' => $teacher1->id, 'notes' => 'Buen desempeño.'],
            ['enrollment_id' => 2, 'value' => 7.00, 'updated_by' => $teacher2->id, 'notes' => 'Puede mejorar.'],
            ['enrollment_id' => 3, 'value' => 9.00, 'updated_by' => $teacher1->id, 'notes' => 'Excelente trabajo.'],
            ['enrollment_id' => 5, 'value' => 6.00, 'updated_by' => $teacher1->id, 'notes' => null],
            
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}

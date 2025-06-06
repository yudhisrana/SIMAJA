<?php

namespace App\Database\Seeds;

use App\Models\Semester;
use CodeIgniter\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesterModel = new Semester();
        $data = [
            ['semester_name' => 'Semester 1'],
            ['semester_name' => 'Semester 2'],
            ['semester_name' => 'Semester 3'],
            ['semester_name' => 'Semester 4'],
            ['semester_name' => 'Semester 5'],
            ['semester_name' => 'Semester 6'],
            ['semester_name' => 'Semester 7'],
            ['semester_name' => 'Semester 8'],
            ['semester_name' => 'Semester 9'],
            ['semester_name' => 'Semester 10'],
        ];

        foreach ($data as $items) {
            $semesterModel->insert($items);
        }
    }
}

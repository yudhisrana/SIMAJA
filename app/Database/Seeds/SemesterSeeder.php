<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run()
    {
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

        $this->db->table('tbl_semester')->insertBatch($data);
    }
}

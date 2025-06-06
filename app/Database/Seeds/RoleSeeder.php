<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 2, 'role_name' => 'Administrator'],
            ['id' => 3, 'role_name' => 'Dosen'],
            ['id' => 4, 'role_name' => 'Mahasiswa'],
        ];

        $this->db->table('tbl_role')->insertBatch($data);
    }
}

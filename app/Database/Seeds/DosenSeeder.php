<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DosenSeeder extends Seeder
{
    public function run()
    {
        $uuidUser = Uuid::uuid4()->toString();
        $uuidDosen = Uuid::uuid4()->toString();
        $dataUser = [
            'id'         => $uuidUser,
            'name'       => 'Dosen 1',
            'username'   => 'dosen1234',
            'password'   => password_hash('dosen1234', PASSWORD_DEFAULT),
            'email'      => 'dosen1@gmail.com',
            'phone'      => '089602324671',
            'address'    => 'Kp. Pabuaran RT003/RW008 No.58 Bojong Gede Kab. Bogor',
            'gender'     => 'L',
            'image'      => '',
            'is_active'  => true,
            'role_id'    => 3,
        ];

        $dataDosen = [
            'id'      => $uuidDosen,
            'user_id' => $uuidUser,
            'nidn'    => '123456',
        ];

        $this->db->table('tbl_user')->insert($dataUser);
        $this->db->table('tbl_dosen')->insert($dataDosen);
    }
}

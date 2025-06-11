<?php

namespace App\Services;

use App\Models\Dosen as ModelsDosen;
use App\Models\User as ModelsUser;
use Config\Database;
use Ramsey\Uuid\Uuid;

class Dosen
{
    protected $db;
    protected $userModel;
    protected $dosenModel;
    public function __construct()
    {
        $this->db = Database::connect();
        $this->userModel = new ModelsUser();;
        $this->dosenModel = new ModelsDosen();
    }

    public function getDosen()
    {
        return $this->dosenModel->dosenWithRelations()->findAll();
    }

    public function createDosen(array $data)
    {
        $userId = Uuid::uuid4()->toString();
        $dosenId = Uuid::uuid4()->toString();

        $dataUser = [
            'id'        => $userId,
            'name'      => $data['name'],
            'username'  => $data['username'],
            'password'  => $data['password'],
            'gender'    => $data['gender'],
            'address'   => $data['address'],
            'is_active' => $data['is_active'],
            // 'role_id'   => 3,
        ];

        $dataDosen = [
            'id'      => $dosenId,
            'user_id' => $dataUser['id'],
            'nidn'    => $data['nidn'],
        ];

        try {
            $this->db->transBegin();

            if (!$this->userModel->insert($dataUser)) {
                throw new \Exception("insert data dosen gagal");
            }

            if (!$this->dosenModel->insert($dataDosen)) {
                throw new \Exception("insert data dosen gagal");
            }

            $this->db->transCommit();

            return [
                'success' => true,
                'message' => 'Data dosen berhasil ditambahkan',
            ];
        } catch (\Throwable $th) {
            $this->db->transRollback();
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }
}

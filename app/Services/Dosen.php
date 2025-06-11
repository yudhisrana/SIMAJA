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

    public function getUserId($id)
    {
        return $this->dosenModel->findUserId($id);
    }

    public function createDosen($data)
    {
        $userId = Uuid::uuid4()->toString();
        $dosenId = Uuid::uuid4()->toString();
        $hashPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $dataUser = [
            'id'        => $userId,
            'name'      => $data['name'],
            'username'  => $data['username'],
            'password'  => $hashPassword,
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'gender'    => $data['gender'],
            'address'   => $data['address'],
            'is_active' => $data['is_active'],
            'role_id'   => 3,
        ];

        if (!empty($data['image']) && $data['image']->isValid()) {
            $imageName = $data['image']->getRandomName();
            $data['image']->move(FCPATH . 'assets/img/dosen', $imageName);
            $dataUser['image'] = $imageName;
        } else {
            $dataUser['image'] = 'default.png';
        }

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

    public function updateDosen($data, $idUser, $idDosen)
    {
        $dataUser = [
            'name'       => $data['name'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'gender'     => $data['gender'],
            'address'    => $data['address'],
            'is_active'  => $data['is_active'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($data['password'])) {
            $dataUser['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($dataUser['password']);
        }

        if (!empty($data['image']) && $data['image']->isValid()) {
            $imageName = $data['image']->getRandomName();
            $data['image']->move(FCPATH . 'assets/img/dosen', $imageName);
            $dataUser['image'] = $imageName;

            $oldImg = $data['old_image'];
            if ($oldImg !== 'default-profile.png') {
                unlink('assets/img/dosen/' . $oldImg);
            }
        } else {
            unset($dataUser['image']);
        }

        $dataDosen = [
            'nidn'    => $data['nidn'],
        ];

        try {
            $this->db->transBegin();

            if (!$this->userModel->update($idUser, $dataUser)) {
                throw new \Exception("update data dosen gagal");
            }

            if (!$this->dosenModel->update($idDosen, $dataDosen)) {
                throw new \Exception("update data dosen gagal");
            }

            $this->db->transCommit();

            return [
                'success' => true,
                'message' => 'Data dosen berhasil diupdate',
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

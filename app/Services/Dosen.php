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
        try {
            $result = $this->dosenModel->findAllData();
            if (empty($result)) {
                return [
                    'success' => true,
                    'data'    => [],
                ];
            }

            return [
                'success' => true,
                'data'    => $result,
            ];
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return [
                'success' => true,
                'data'    => [],
            ];
        }
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
            $dataUser['image'] = 'default-profile.png';
        }

        $dataDosen = [
            'id'      => $dosenId,
            'user_id' => $dataUser['id'],
            'nidn'    => $data['nidn'],
        ];

        try {
            $this->db->transBegin();

            if (!$this->userModel->saveData($dataUser)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal menambahkan data dosen',
                ];
            }

            if (!$this->dosenModel->saveData($dataDosen)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal menambahkan data dosen',
                ];
            }

            $this->db->transCommit();

            return [
                'success' => true,
                'code'    => 201,
                'message' => 'Data dosen berhasil ditambahkan',
            ];
        } catch (\Throwable $th) {
            $this->db->transRollback();
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }

    public function updateDosen($data, $idDosen, $idUser)
    {
        $existing = $this->dosenModel->findById($idDosen);
        if (!$existing) {
            return [
                'success'  => false,
                'code'    => 404,
                'message' => 'Data dosen tidak ditemukan'
            ];
        }

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
                unlink(FCPATH . 'assets/img/dosen/' . $oldImg);
            }
        } else {
            unset($dataUser['image']);
        }

        $dataDosen = [
            'nidn'    => $data['nidn'],
        ];

        try {
            $this->db->transBegin();

            if (!$this->userModel->updateData($idUser, $dataUser)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal menambahkan data dosen',
                ];
            }

            if (!$this->dosenModel->updateData($idDosen, $dataDosen)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal menambahkan data dosen',
                ];
            }

            $this->db->transCommit();

            return [
                'success' => true,
                'code'    => 200,
                'message' => 'Data dosen berhasil diupdate',
            ];
        } catch (\Throwable $th) {
            $this->db->transRollback();
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }

    public function deleteDosen($id)
    {
        $existing = $this->dosenModel->findById($id);
        if (!$existing) {
            return [
                'success' => false,
                'code'    => 404,
                'message' => 'Data dosen tidak ditemukan'
            ];
        }

        $user = $this->userModel->findByID($existing->user_id);

        try {
            if (!$this->userModel->deleteData($user->id)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal hapus data dosen',
                ];
            }

            if (!empty($user->image) && $user->image !== 'default-profile.png') {
                $imgPath = FCPATH . '/assets/img/dosen/' . $user->image;
                unlink($imgPath);
            }

            return [
                'success' => true,
                'code'    => 200,
                'message' => 'Data dosen berhasil dihapus',
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }
}

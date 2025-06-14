<?php

namespace App\Models;

use App\Entities\Dosen as EntitiesDosen;
use CodeIgniter\Model;

class Dosen extends Model
{
    protected $table            = 'tbl_dosen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = EntitiesDosen::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user_id', 'nidn'];

    public function findAllData()
    {
        return $this->select('tbl_dosen.*, tbl_user.name, tbl_user.username, tbl_user.email, tbl_user.phone, tbl_user.address, tbl_user.gender, tbl_user.image, tbl_user.is_active, tbl_user.created_at, tbl_user.updated_at')
            ->join('tbl_user', 'tbl_user.id = tbl_dosen.user_id')
            ->where('tbl_user.role_id', 3)
            ->orderBy('tbl_user.created_at', 'DESC')
            ->findAll();
    }

    public function findById($id)
    {
        return $this->select()->where('id', $id)->first();
    }

    public function saveData($data)
    {
        return $this->insert($data);
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }
}

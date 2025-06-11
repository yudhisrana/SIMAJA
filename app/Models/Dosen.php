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

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function dosenWithRelations()
    {
        return $this->select('tbl_dosen.*, tbl_user.name, tbl_user.username, tbl_user.email, tbl_user.phone, tbl_user.address, tbl_user.gender, tbl_user.is_active, tbl_user.created_at, tbl_user.updated_at')
            ->join('tbl_user', 'tbl_user.id = tbl_dosen.user_id')
            ->where('tbl_user.role_id', 3)
            ->orderBy('tbl_user.created_at', 'DESC');
    }

    public function findUserId($id)
    {
        return $this->select('user_id')
            ->where('id', $id)
            ->first();
    }
}

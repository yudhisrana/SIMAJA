<?php

namespace App\Models;

use App\Entities\Kelas as EntitiesKelas;
use CodeIgniter\Model;

class Kelas extends Model
{
    protected $table            = 'tbl_kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = EntitiesKelas::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'kelas_name', 'semester_id', 'tahun_ajaran_id', 'is_active', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

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

    public function findAllWithRelation()
    {
        return $this->select('tbl_kelas.*, tbl_semester.semester_name, tbl_tahun_ajaran.tahun')
            ->join('tbl_semester', 'tbl_semester.id = tbl_kelas.semester_id')
            ->join('tbl_tahun_ajaran', 'tbl_tahun_ajaran.id = tbl_kelas.tahun_ajaran_id')
            ->orderBy('tbl_kelas.created_at', 'ASC')
            ->findAll();
    }
}

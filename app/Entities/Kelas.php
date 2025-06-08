<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Kelas extends Entity
{
    protected $attributes = [
        'id'              => null,
        'kelas_name'      => null,
        'semester_id'     => null,
        'tahun_ajaran_id' => null,
        'is_active'       => true,
        'created_at'      => null,
        'updated_at'      => null,
    ];
    protected $datamap = [
        'semesterName' => 'semester_name',
        'tahunAjaran'  => 'tahun'
    ];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}

<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TahunAjaran extends Entity
{
    protected $attributes = [
        'id'    => null,
        'tahun' => null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}

<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Dosen extends Entity
{
    protected $attributes = [
        'id'       => null,
        'user_id'  => null,
        'nidn'     => null,
    ];
    protected $datamap = [
        'name'      => 'name',
        'username'  => 'username',
        'email'     => 'email',
        'phone'     => 'phone',
        'address'   => 'address',
        'gender'    => 'gender',
        'image'     => 'image',
        'isActive'  => 'is_active',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}

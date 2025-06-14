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
        'id'        => 'id',
        'userId'    => 'user_id',
        'nidn'      => 'nidn',
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
}

<?php

namespace App\Validation;

class Dosen
{
    public function ruleStore()
    {
        return [
            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Field nama dosen tidak boleh kosong',
                    'min_length' => 'Nama dosen minimal 3 karakter',
                ]
            ],
            'nidn' => [
                'rules' => 'required|min_length[6]|is_unique[tbl_dosen.nidn]',
                'errors' => [
                    'required' => 'Field NIDN tidak boleh kosong',
                    'min_length' => 'NIDN minimal 6 karakter',
                    'is_unique' => 'NIDN sudah terdaftar',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[6]|is_unique[tbl_user.username]',
                'errors' => [
                    'required' => 'Field username tidak boleh kosong',
                    'min_length' => 'Username minimal 6 karakter',
                    'is_unique' => 'Username sudah digunakan',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Field password tidak boleh kosong',
                    'min_length' => 'Password minimal 6 karakter',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field jenis kelamin wajib dipilih',
                ]
            ],
        ];
    }

    public function ruleUpdate($idUser, $idDosen)
    {
        return [
            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Field nama dosen tidak boleh kosong',
                    'min_length' => 'Nama dosen minimal 3 karakter',
                ]
            ],
            'nidn' => [
                'rules' => 'required|min_length[6]|is_unique[tbl_dosen.nidn,id,' . $idDosen . ']',
                'errors' => [
                    'required' => 'Field NIDN tidak boleh kosong',
                    'min_length' => 'NIDN minimal 6 karakter',
                    'is_unique' => 'NIDN sudah terdaftar',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[6]|is_unique[tbl_user.username,id,' . $idUser . ']',
                'errors' => [
                    'required' => 'Field username tidak boleh kosong',
                    'min_length' => 'Username minimal 6 karakter',
                    'is_unique' => 'Username sudah digunakan',
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field jenis kelamin wajib dipilih',
                ]
            ],
        ];
    }
}

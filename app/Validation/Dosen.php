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
            'email' => [
                'rules' => 'permit_empty|valid_email|is_unique[tbl_user.email]',
                'errors' => [
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar',
                ]
            ],
            'phone' => [
                'rules' => 'permit_empty|regex_match[/^[0-9]{10,15}$/]',
                'errors' => [
                    'regex_match' => 'Nomor telepon harus berupa angka dengan panjang 10-15 karakter',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field jenis kelamin wajib dipilih',
                ]
            ],
            'image' => [
                'rules' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,1024]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar',
                    'mime_in' => 'File gambar harus berformat jpg, jpeg, atau png',
                    'max_size' => 'Ukuran gambar maksimal 1MB',
                ]
            ]
        ];
    }

    public function ruleUpdate($idDosen, $idUser)
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
            'email' => [
                'rules' => 'permit_empty|valid_email|is_unique[tbl_user.email,id,' . $idUser . ']',
                'errors' => [
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar',
                ]
            ],
            'phone' => [
                'rules' => 'permit_empty|regex_match[/^[0-9]{10,15}$/]',
                'errors' => [
                    'regex_match' => 'Nomor telepon harus berupa angka dengan panjang 10-15 karakter',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field jenis kelamin wajib dipilih',
                ]
            ],
            'image' => [
                'rules' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,1024]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar',
                    'mime_in' => 'File gambar harus berformat jpg, jpeg, atau png',
                    'max_size' => 'Ukuran gambar maksimal 1MB',
                ]
            ]
        ];
    }
}

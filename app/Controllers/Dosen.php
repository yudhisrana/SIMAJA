<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\Dosen as ServicesDosen;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class Dosen extends BaseController
{
    protected $dosenService;
    protected $validation;
    public function __construct()
    {
        $this->dosenService = new ServicesDosen();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $dataDosen = $this->dosenService->getDosen();
        $data = [
            'title'        => 'SIMAJA - Dosen',
            'table_name'   => 'Data Dosen',
            'dosen'        => $dataDosen,
        ];
        return view("dosen", $data);
    }

    public function store()
    {
        $rules = [
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

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validation->getErrors(),
            ]);
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'nidn'      => $this->request->getPost('nidn'),
            'username'  => $this->request->getPost('username'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'gender'    => $this->request->getPost('gender'),
            'image'     => $this->request->getPost('image'),
            'address'   => $this->request->getPost('address'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        $result = $this->dosenService->createDosen($data);
        if ($result['success']) {
            return $this->response
                ->setStatusCode(200)
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode(500)
            ->setJSON($result);
    }
}

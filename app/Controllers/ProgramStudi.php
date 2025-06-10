<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgramStudi as ModelsProgramStudi;
use CodeIgniter\HTTP\ResponseInterface;

class ProgramStudi extends BaseController
{
    protected $prodiModel;
    protected $validation;
    public function __construct()
    {
        $this->prodiModel = new ModelsProgramStudi();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $dataProdi = $this->prodiModel->findAll();
        $data = [
            'title'        => 'SIMAJA - Program Studi',
            'table_name'   => 'Data Program Studi',
            'prodi'        => $dataProdi,
        ];
        return view("program-studi", $data);
    }

    public function store()
    {
        $rules = [
            'prodi' => [
                'rules' => 'required|min_length[2]|is_unique[tbl_prodi.prodi_name]',
                'errors' => [
                    'required' => 'Field program studi tidak boleh kosong',
                    'min_length' => 'Program studi minimal 2 karakter',
                    'is_unique' => 'Program studi sudah digunakan',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validation->getErrors()
            ]);
        }

        $data = [
            'prodi_name' => ucwords(strtolower($this->request->getPost('prodi')))
        ];

        $this->prodiModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil menambahkan data program studi'
        ]);
    }

    public function update($id)
    {
        $rules = [
            'prodi' => [
                'rules' => 'required|min_length[2]|is_unique[tbl_prodi.prodi_name,id,' . $id . ']',
                'errors' => [
                    'required' => 'Field program studi tidak boleh kosong',
                    'min_length' => 'Program studi minimal 2 karakter',
                    'is_unique' => 'Program studi sudah digunakan',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validation->getErrors()
            ]);
        }

        $data = [
            'prodi_name' => ucwords(strtolower($this->request->getPost('prodi'))),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->prodiModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil update data program studi'
        ]);
    }

    public function destroy($id)
    {
        $this->prodiModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil hapus data program studi'
        ]);
    }
}

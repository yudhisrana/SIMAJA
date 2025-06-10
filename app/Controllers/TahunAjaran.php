<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TahunAjaran as ModelsTahunAjaran;
use CodeIgniter\HTTP\ResponseInterface;

class TahunAjaran extends BaseController
{
    protected $tahunAjaranModel;
    protected $validation;
    public function __construct()
    {
        $this->tahunAjaranModel = new ModelsTahunAjaran();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $dataTahunAjaran = $this->tahunAjaranModel->findAll();
        $data = [
            'title'        => 'SIMAJA - Tahun Ajaran',
            'table_name'   => 'Data Tahun Ajaran',
            'tahun_ajaran' => $dataTahunAjaran,
        ];
        return view("tahun-ajaran", $data);
    }

    public function store()
    {

        $rules = [
            'tahun_ajaran' => [
                'rules' => 'required|min_length[9]|is_unique[tbl_tahun_ajaran.tahun]',
                'errors' => [
                    'required' => 'Field tahun ajaran tidak boleh kosong',
                    'min_length' => 'Tahun ajaran minimal 9 karakter',
                    'is_unique' => 'Tahun ajaran sudah digunakan',
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
            'tahun' => ucwords(strtolower($this->request->getPost('tahun_ajaran')))
        ];

        $this->tahunAjaranModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil menambahkan data tahun ajaran'
        ]);
    }

    public function update($id)
    {

        $rules = [
            'tahun_ajaran' => [
                'rules' => 'required|min_length[9]|is_unique[tbl_tahun_ajaran.tahun,id,' . $id . ']',
                'errors' => [
                    'required' => 'Field tahun ajaran tidak boleh kosong',
                    'min_length' => 'Tahun ajaran minimal 9 karakter',
                    'is_unique' => 'Tahun ajaran sudah digunakan',
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
            'tahun' => ucwords(strtolower($this->request->getPost('tahun_ajaran'))),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->tahunAjaranModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil update data tahun ajaran'
        ]);
    }

    public function destroy($id)
    {
        $this->tahunAjaranModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil hapus data tahun ajaran'
        ]);
    }
}

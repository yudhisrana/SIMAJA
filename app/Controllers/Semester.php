<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Semester as ModelsSemester;
use CodeIgniter\HTTP\ResponseInterface;

class Semester extends BaseController
{
    protected $semesterModel;
    protected $validation;
    public function __construct()
    {
        $this->semesterModel = new ModelsSemester();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $dataSemester = $this->semesterModel->findAll();
        $data = [
            'title'     => 'SIMAJA - Semester',
            'page_name' => 'Semester',
            'semester'  => $dataSemester
        ];
        return view("semester", $data);
    }

    public function store()
    {

        $rules = [
            'nama_semester' => [
                'rules' => 'required|min_length[3]|is_unique[tbl_semester.semester_name]',
                'errors' => [
                    'required' => 'Field semester tidak boleh kosong',
                    'min_length' => 'Nama semester minimal 3 karakter',
                    'is_unique' => 'Nama semester sudah digunakan',
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
            'semester_name' => ucwords(strtolower($this->request->getPost('nama_semester')))
        ];

        $this->semesterModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil menambahkan data semester'
        ]);
    }

    public function update($id)
    {

        $rules = [
            'nama_semester' => [
                'rules' => 'required|min_length[3]|is_unique[tbl_semester.semester_name,id,' . $id . ']',
                'errors' => [
                    'required' => 'Field semester tidak boleh kosong',
                    'min_length' => 'Nama semester minimal 3 karakter',
                    'is_unique' => 'Nama semester sudah digunakan',
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
            'semester_name' => ucwords(strtolower($this->request->getPost('nama_semester'))),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->semesterModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil update data semester'
        ]);
    }

    public function destroy($id)
    {
        $this->semesterModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil hapus data semester'
        ]);
    }
}

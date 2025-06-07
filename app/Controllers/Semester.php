<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Semester as ModelsSemester;
use CodeIgniter\HTTP\ResponseInterface;

class Semester extends BaseController
{
    protected $semesterModel;
    public function __construct()
    {
        $this->semesterModel = new ModelsSemester();
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
        $validation = \Config\Services::validation();

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
                'errors' => $validation->getErrors()
            ]);
        }

        $data = [
            'semester_name' => $this->request->getPost('semester_name')
        ];

        $this->semesterModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil menambahkan data semester'
        ]);
    }
}

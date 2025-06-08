<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kelas as ModelsKelas;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Ramsey\Uuid\Uuid;
use CodeIgniter\HTTP\ResponseInterface;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $semesterModel;
    protected $tahunAjaranModel;
    protected $validation;
    public function __construct()
    {
        $this->kelasModel = new ModelsKelas();
        $this->semesterModel = new Semester();
        $this->tahunAjaranModel = new TahunAjaran();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $dataKelas = $this->kelasModel->findAllWithRelation();
        $dataSemester = $this->semesterModel->findAll();
        $dataTahunAjaran = $this->tahunAjaranModel->findAll();
        $data = [
            'title'        => 'SIMAJA - Kelas',
            'page_name'    => 'Kelas',
            'kelas'        => $dataKelas,
            'semester'     => $dataSemester,
            'tahun_ajaran' => $dataTahunAjaran
        ];
        return view("kelas", $data);
    }

    public function store()
    {
        $rules = [
            'kelas' => [
                'rules' => 'required|min_length[8]|is_unique[tbl_kelas.kelas_name]',
                'errors' => [
                    'required' => 'Field nama kelas tidak boleh kosong',
                    'min_length' => 'Nama kelas minimal 8 karakter',
                    'is_unique' => 'Nama kelas sudah digunakan',
                ],
            ],
            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field semester tidak boleh kosong',
                ],
            ],
            'tahun_ajaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field tahun ajaran tidak boleh kosong',
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
            'id'              => Uuid::uuid4()->toString(),
            'kelas_name'      => strtoupper($this->request->getPost('kelas')),
            'semester_id'     => $this->request->getPost('semester'),
            'tahun_ajaran_id' => $this->request->getPost('tahun_ajaran'),
        ];

        $this->kelasModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil menambahkan data kelas'
        ]);
    }

    public function update($id)
    {
        $rules = [
            'kelas' => [
                'rules' => 'required|min_length[8]|is_unique[tbl_kelas.kelas_name,id,' . $id . ']',
                'errors' => [
                    'required' => 'Field nama kelas tidak boleh kosong',
                    'min_length' => 'Nama kelas minimal 8 karakter',
                    'is_unique' => 'Nama kelas sudah digunakan',
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
            'kelas_name'      => strtoupper($this->request->getPost('kelas')),
            'semester_id'     => $this->request->getPost('semester'),
            'tahun_ajaran_id' => $this->request->getPost('tahun_ajaran'),
            'is_active'       => $this->request->getPost('is_active'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        $this->kelasModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil update data kelas'
        ]);
    }

    public function destroy($id)
    {
        $this->kelasModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil menghapus data kelas',
        ]);
    }
}

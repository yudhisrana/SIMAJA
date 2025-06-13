<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TahunAjaran as ModelsTahunAjaran;
use App\Services\TahunAjaran as ServicesTahunAjaran;
use App\Validation\TahunAjaran as ValidationTahunAjaran;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class TahunAjaran extends BaseController
{
    protected $tahunAjaranService;
    protected $tahunAjaranValidation;
    protected $validation;
    public function __construct()
    {
        $this->tahunAjaranService = new ServicesTahunAjaran();
        $this->tahunAjaranValidation = new ValidationTahunAjaran();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $dataTahunAjaran = $this->tahunAjaranService->getData();
        if (!$dataTahunAjaran['success']) {
            return $this->response->setStatusCode(500)->setJSON($dataTahunAjaran);
        }

        $data = [
            'title'        => 'SIMAJA - Tahun Ajaran',
            'table_name'   => 'Data Tahun Ajaran',
            'tahun_ajaran' => $dataTahunAjaran['data'],
        ];

        return view("tahun-ajaran", $data);
    }

    public function store()
    {
        $rules = $this->tahunAjaranValidation->ruleStore();
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validation->getErrors()
            ]);
        }

        $data = [
            'tahun' => $this->request->getPost('tahun_ajaran')
        ];

        $result = $this->tahunAjaranService->createTahunAjaran($data);
        if (!$result['success']) {
            return $this->response->setStatusCode(500)->setJSON($result);
        }

        return $this->response->setStatusCode(200)->setJSON($result);
    }

    public function update($id)
    {
        $rules = $this->tahunAjaranValidation->ruleUpdate($id);
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validation->getErrors()
            ]);
        }

        $data = [
            'tahun' => $this->request->getPost('tahun_ajaran'),
        ];

        $result = $this->tahunAjaranService->updateTahunAjaran($id, $data);
        if (!$result['success']) {
            return $this->response->setStatusCode(500)->setJSON($result);
        }

        return $this->response->setStatusCode(200)->setJSON($result);
    }

    public function destroy($id)
    {
        $result = $this->tahunAjaranService->deleteTahunAjaran($id);
        if (!$result['success']) {
            return $this->response->setStatusCode(500)->setJSON($result);
        }

        return $this->response->setStatusCode(200)->setJSON($result);
    }
}

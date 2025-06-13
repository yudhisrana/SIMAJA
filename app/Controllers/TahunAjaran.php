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
    protected $tahunAjaranModel;
    protected $tahunAjaranService;
    protected $ruleValidation;
    protected $validation;
    public function __construct()
    {
        $this->tahunAjaranModel = new ModelsTahunAjaran();
        $this->tahunAjaranService = new ServicesTahunAjaran();
        $this->ruleValidation = new ValidationTahunAjaran();
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
        $rules = $this->ruleValidation->ruleStore();
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
        $rules = $this->ruleValidation->ruleUpdate($id);
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

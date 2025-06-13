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
        $tahunAjaran = $dataTahunAjaran['success'] ? $dataTahunAjaran['data'] : [];

        $data = [
            'title'        => 'SIMAJA - Tahun Ajaran',
            'table_name'   => 'Data Tahun Ajaran',
            'tahun_ajaran' => $tahunAjaran,
        ];

        return view("tahun-ajaran", $data);
    }

    public function store()
    {
        $rules = $this->tahunAjaranValidation->ruleStore();
        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => $this->validation->getErrors()
                ]);
        }

        $data = [
            'tahun' => $this->request->getPost('tahun_ajaran')
        ];

        $result = $this->tahunAjaranService->createTahunAjaran($data);
        if (!$result['success']) {
            return $this->response->setStatusCode($result['code'])->setJSON($result);
        }

        return $this->response->setStatusCode($result['code'])->setJSON($result);
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
            return $this->response->setStatusCode($result['code'])->setJSON($result);
        }

        return $this->response->setStatusCode($result['code'])->setJSON($result);
    }

    public function destroy($id)
    {
        $result = $this->tahunAjaranService->deleteTahunAjaran($id);
        if (!$result['success']) {
            return $this->response->setStatusCode($result['code'])->setJSON($result);
        }

        return $this->response->setStatusCode($result['code'])->setJSON($result);
    }
}

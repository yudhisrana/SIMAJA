<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\Dosen as ServicesDosen;
use App\Validation\Dosen as ValidationDosen;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class Dosen extends BaseController
{
    protected $dosenService;
    protected $ruleValidation;
    protected $validation;
    public function __construct()
    {
        $this->dosenService = new ServicesDosen();
        $this->ruleValidation = new ValidationDosen();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $dataDosen = $this->dosenService->getDosen();
        $dosen = $dataDosen['success'] ? $dataDosen['data'] : [];

        $data = [
            'title'        => 'SIMAJA - Dosen',
            'table_name'   => 'Data Dosen',
            'dosen'        => $dosen,
        ];

        return view("dosen", $data);
    }

    public function store()
    {
        $rules = $this->ruleValidation->ruleStore();
        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => $this->validation->getErrors(),
                ]);
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'nidn'      => $this->request->getPost('nidn'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'gender'    => $this->request->getPost('gender'),
            'image'     => $this->request->getFile('image'),
            'address'   => $this->request->getPost('address'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        $result = $this->dosenService->createDosen($data);
        if (!$result['success']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode($result['code'])
            ->setJSON($result);
    }

    public function update($id, $userId)
    {
        $rules = $this->ruleValidation->ruleUpdate($id, $userId);
        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => $this->validation->getErrors(),
                ]);
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'nidn'      => $this->request->getPost('nidn'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'gender'    => $this->request->getPost('gender'),
            'image'     => $this->request->getFile('image'),
            'old_image' => $this->request->getPost('old_image'),
            'address'   => $this->request->getPost('address'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        $result = $this->dosenService->updateDosen($data, $id, $userId);
        if (!$result['success']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode($result['code'])
            ->setJSON($result);
    }

    public function destroy($id)
    {
        $result = $this->dosenService->deleteDosen($id);
        if (!$result['success']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode($result['code'])
            ->setJSON($result);
    }
}

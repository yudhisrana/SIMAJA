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
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'SIMAJA - Dashboard',
        ];
        return view("dashboard", $data);
    }
}

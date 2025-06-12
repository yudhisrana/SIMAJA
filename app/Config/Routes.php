<?php

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Dosen;
use App\Controllers\Home;
use App\Controllers\Kelas;
use App\Controllers\ProgramStudi;
use App\Controllers\Semester;
use App\Controllers\TahunAjaran;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);

// Route Login
$routes->get('/login', [Auth::class, 'index']);

// Route Dashboard
$routes->get('/dashboard', [Dashboard::class, 'index']);

// Route Semester
$routes->get('/semester', [Semester::class, 'index']);
$routes->post('/semester/create-data', [Semester::class, 'store']);
$routes->post('/semester/update-data/(:num)', [Semester::class, 'update']);
$routes->post('/semester/delete-data/(:num)', [Semester::class, 'destroy']);

// Route Tahun Ajaran
$routes->get('/tahun-ajaran', [TahunAjaran::class, 'index']);
$routes->post('/tahun-ajaran/create-data', [TahunAjaran::class, 'store']);
$routes->post('/tahun-ajaran/update-data/(:num)', [TahunAjaran::class, 'update']);
$routes->post('/tahun-ajaran/delete-data/(:num)', [TahunAjaran::class, 'destroy']);

// Route Kelas
$routes->get('/kelas', [Kelas::class, 'index']);
$routes->post('/kelas/create-data', [Kelas::class, 'store']);
$routes->post('/kelas/update-data/(:hash)', [Kelas::class, 'update']);
$routes->post('/kelas/delete-data/(:hash)', [Kelas::class, 'destroy']);

// Route Program Studi
$routes->get('/program-studi', [ProgramStudi::class, 'index']);
$routes->post('/program-studi/create-data', [ProgramStudi::class, 'store']);
$routes->post('/program-studi/update-data/(:num)', [ProgramStudi::class, 'update']);
$routes->post('/program-studi/delete-data/(:num)', [ProgramStudi::class, 'destroy']);

// Route Dosen
$routes->get('/user/dosen', [Dosen::class, 'index']);
$routes->post('/user/dosen/create-data', [Dosen::class, 'store']);
$routes->post('/user/dosen/update-data/(:hash)', [Dosen::class, 'update']);
$routes->post('/user/dosen/delete-data/(:hash)', [Dosen::class, 'destroy']);

// Route Mahasiswa
// $routes->get('/user', [User::class, 'index']);
// $routes->post('/user/create-data', [User::class, 'store']);
// $routes->post('/user/update-data/(:num)', [User::class, 'update']);
// $routes->post('/user/delete-data/(:num)', [User::class, 'destroy']);
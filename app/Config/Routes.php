<?php

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Home;
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

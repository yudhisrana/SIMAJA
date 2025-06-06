<?php

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Home;
use App\Controllers\Semester;
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

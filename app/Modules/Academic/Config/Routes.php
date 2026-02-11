<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->group('academic', ['namespace' => 'Modules\Academic\Controllers'], function($routes) {
    $routes->get('/', 'AcademicController::index');
    $routes->get('create', 'AcademicController::create');
    $routes->post('/', 'AcademicController::store');
    $routes->get('(:num)', 'AcademicController::show/$1');
    $routes->get('(:num)/edit', 'AcademicController::edit/$1');
    $routes->post('(:num)', 'AcademicController::update/$1');
    $routes->post('(:num)/delete', 'AcademicController::delete/$1');
});
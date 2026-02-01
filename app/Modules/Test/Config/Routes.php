<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->group('test', ['namespace' => 'Modules\Test\Controllers'], function($routes) {
    $routes->get('/', 'TestController::index');
    $routes->get('create', 'TestController::create');
    $routes->post('/', 'TestController::store');
    $routes->get('(:num)', 'TestController::show/$1');
    $routes->get('(:num)/edit', 'TestController::edit/$1');
    $routes->post('(:num)', 'TestController::update/$1');
    $routes->post('(:num)/delete', 'TestController::delete/$1');
});
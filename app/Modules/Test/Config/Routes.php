<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

// Test Module Routes (Admin)
$routes->group('test', ['namespace' => 'Modules\Test\Controllers', 'filter' => 'session'], function ($routes) {
    // HSK Registrations
    $routes->get('hsk-registrations', 'TestController::hskRegistrations');
    $routes->get('hsk-registrations/view/(:num)', 'TestController::viewHskRegistration/$1');
    $routes->post('hsk-registrations/update-status/(:num)', 'TestController::updateHskStatus/$1');
    $routes->post('hsk-registrations/delete/(:num)', 'TestController::deleteHskRegistration/$1');
});

// Test Module API Routes
$routes->group('api/test', ['namespace' => 'Modules\Test\Controllers\Api', 'filter' => 'tokens'], function ($routes) {
    $routes->get('hsk-registrations', 'TestApiController::getHskRegistrations');
    $routes->get('hsk-registrations/(:num)', 'TestApiController::getHskRegistration/$1');
    $routes->post('hsk-registrations', 'TestApiController::createHskRegistration');
    $routes->put('hsk-registrations/(:num)', 'TestApiController::updateHskRegistration/$1');
    $routes->delete('hsk-registrations/(:num)', 'TestApiController::deleteHskRegistration/$1');
    $routes->post('hsk-registrations/(:num)/status', 'TestApiController::updateStatus/$1');
});

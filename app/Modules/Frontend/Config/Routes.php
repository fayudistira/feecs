<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->group('', ['namespace' => 'Modules\Frontend\Controllers'], function($routes) {
    $routes->get('/', 'PageController::home');
    $routes->get('about', 'PageController::about');
    $routes->get('contact', 'PageController::contact');
    $routes->get('apply', 'PageController::apply');
    $routes->post('apply/submit', 'PageController::submitApplication');
    $routes->get('apply/success', 'PageController::applySuccess');
});

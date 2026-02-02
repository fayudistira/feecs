<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->group('', ['namespace' => 'Modules\Frontend\Controllers'], function($routes) {
    $routes->get('/', 'PageController::home');
    $routes->get('about', 'PageController::about');
    $routes->get('contact', 'PageController::contact');
    
    // Programs routes
    $routes->get('programs', 'PageController::programs');
    $routes->get('programs/(:segment)', 'PageController::programDetail/$1');
    
    // Apply routes
    $routes->get('apply', 'PageController::apply');
    $routes->get('apply/(:segment)', 'PageController::applyWithProgram/$1');
    $routes->post('apply/submit', 'PageController::submitApplication');
    $routes->get('apply/success', 'PageController::applySuccess');
});

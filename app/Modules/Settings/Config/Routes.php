<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->group('settings', ['namespace' => 'Modules\Settings\Controllers'], function ($routes) {
    $routes->get('/', 'SettingsController::index');
    $routes->get('cleanup', 'SettingsController::cleanup');
    $routes->post('cleanup', 'SettingsController::doCleanup');
    $routes->get('test-data', 'SettingsController::testData');
    $routes->post('generate-test-data', 'SettingsController::generateTestData');
    
    // Terms and Conditions Management
    $routes->get('terms', 'TermsController::index');
    $routes->get('terms/create', 'TermsController::create');
    $routes->post('terms/store', 'TermsController::store');
    $routes->get('terms/edit/(:num)', 'TermsController::edit/$1');
    $routes->post('terms/update/(:num)', 'TermsController::update/$1');
    $routes->post('terms/delete/(:num)', 'TermsController::delete/$1');
    $routes->post('terms/toggle/(:num)', 'TermsController::toggle/$1');
});

<?php

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->get('/', 'Modules\Frontend\Controllers\PageController::home');
$routes->get('about', 'Modules\Frontend\Controllers\PageController::about');
$routes->get('contact', 'Modules\Frontend\Controllers\PageController::contact');
$routes->get('apply', 'Modules\Frontend\Controllers\PageController::apply');
$routes->post('apply/submit', 'Modules\Frontend\Controllers\PageController::submitApplication');
$routes->get('apply/success', 'Modules\Frontend\Controllers\PageController::applySuccess');

<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Default route is handled by Frontend module
// $routes->get('/', 'Home::index');

// Register Shield routes except login and register (we'll override those)
service('auth')->routes($routes, ['except' => ['login', 'register']]);

// Custom login and register routes with session handling
$routes->get('login', '\App\Controllers\Auth\LoginController::loginView', ['as' => 'login']);
$routes->post('login', '\App\Controllers\Auth\LoginController::loginAction');
$routes->get('register', '\App\Controllers\Auth\RegisterController::registerView', ['as' => 'register']);
$routes->post('register', '\App\Controllers\Auth\RegisterController::registerAction');

//Auto-Load Modules' Routes
$modulesPath = APPPATH . 'Modules/';
if (is_dir($modulesPath)) {
    foreach (scandir($modulesPath) as $module) {
        if ($module === '.' || $module === '..') {
            continue;
        }
        $routesPath = $modulesPath . $module . '/Config/Routes.php';
        if (file_exists($routesPath)) {
            include $routesPath;
        }
    }
}

// Route to serve uploaded files from writable/uploads (captures all nested paths)
// IMPORTANT: This must be AFTER module routes to avoid being overridden
$routes->get('writable/uploads/(:segment)/(:segment)/(:any)', 'FileController::serve/$1/$2/$3');
$routes->get('writable/uploads/(:segment)/(:any)', 'FileController::serve/$1/$2');
$routes->get('writable/uploads/(:any)', 'FileController::serve/$1');

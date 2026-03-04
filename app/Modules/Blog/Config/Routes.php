<?php

/**
 * Blog Module Routes Configuration
 * 
 * Defines all routes for the Blog module including:
 * - Admin management routes
 * - Public blog routes
 * - API routes
 */

use CodeIgniter\Config\Services;

$routes = Services::routes();

// ==========================================
// ADMIN ROUTES
// ==========================================
$routes->group('admin/blog', [
    'namespace' => 'Modules\Blog\Controllers',
    'filter' => 'permission:blog.manage'
], function ($routes) {
    // Blog Posts Management
    $routes->get('/', 'BlogController::index');
    $routes->get('create', 'BlogController::create');
    $routes->post('store', 'BlogController::store');
    $routes->get('edit/(:num)', 'BlogController::edit/$1');
    $routes->post('update/(:num)', 'BlogController::update/$1');
    $routes->post('delete/(:num)', 'BlogController::delete/$1');
    $routes->post('toggle/(:num)', 'BlogController::toggle/$1');
    $routes->post('feature/(:num)', 'BlogController::feature/$1');
    
    // Categories Management
    $routes->get('categories', 'CategoryController::index');
    $routes->get('categories/create', 'CategoryController::create');
    $routes->post('categories/store', 'CategoryController::store');
    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'CategoryController::delete/$1');
    $routes->post('categories/toggle/(:num)', 'CategoryController::toggle/$1');
    
    // Tags Management
    $routes->get('tags', 'TagController::index');
    $routes->post('tags/store', 'TagController::store');
    $routes->post('tags/delete/(:num)', 'TagController::delete/$1');
    
    // AI Features
    $routes->post('ai/generate-summary', 'BlogController::generateSummary');
    $routes->post('ai/extract-keywords', 'BlogController::extractKeywords');
    
    // Statistics
    $routes->get('stats', 'BlogController::stats');
});

// ==========================================
// PUBLIC ROUTES
// ==========================================
$routes->group('blog', ['namespace' => 'Modules\Blog\Controllers\Frontend'], function ($routes) {
    // Main blog routes
    $routes->get('/', 'BlogController::index');
    $routes->get('(:segment)', 'BlogController::post/$1'); // Must be last
    
    // Category routes
    $routes->get('category/(:segment)', 'BlogController::category/$1');
    
    // Tag routes
    $routes->get('tag/(:segment)', 'BlogController::tag/$1');
    
    // Search
    $routes->get('search', 'BlogController::search');
    
    // RSS Feed
    $routes->get('feed', 'BlogController::feed');
});

// Sitemap (outside blog group for cleaner URLs)
$routes->get('sitemap.xml', 'Frontend\BlogController::sitemap');

// ==========================================
// PUBLIC API ROUTES
// ==========================================
$routes->group('api/blog', ['namespace' => 'Modules\Blog\Controllers\Api'], function ($routes) {
    // Posts
    $routes->get('posts', 'BlogApiController::posts');
    $routes->get('posts/(:segment)', 'BlogApiController::post/$1');
    $routes->get('posts/featured', 'BlogApiController::featured');
    
    // Categories
    $routes->get('categories', 'BlogApiController::categories');
    $routes->get('categories/(:segment)', 'BlogApiController::category/$1');
    
    // Tags
    $routes->get('tags', 'BlogApiController::tags');
    $routes->get('tags/(:segment)', 'BlogApiController::tag/$1');
    
    // Search
    $routes->get('search', 'BlogApiController::search');
    
    // Sitemap
    $routes->get('sitemap', 'BlogApiController::sitemap');
});

// ==========================================
// ADMIN API ROUTES (Protected)
// ==========================================
$routes->group('api/admin/blog', [
    'namespace' => 'Modules\Blog\Controllers\Api',
    'filter' => 'permission:blog.manage'
], function ($routes) {
    // Posts CRUD
    $routes->get('posts', 'BlogAdminApiController::posts');
    $routes->post('posts', 'BlogAdminApiController::createPost');
    $routes->get('posts/(:num)', 'BlogAdminApiController::post/$1');
    $routes->put('posts/(:num)', 'BlogAdminApiController::updatePost/$1');
    $routes->delete('posts/(:num)', 'BlogAdminApiController::deletePost/$1');
    $routes->post('posts/(:num)/toggle', 'BlogAdminApiController::togglePost/$1');
    $routes->post('posts/(:num)/feature', 'BlogAdminApiController::featurePost/$1');
    
    // Categories CRUD
    $routes->get('categories', 'BlogAdminApiController::categories');
    $routes->post('categories', 'BlogAdminApiController::createCategory');
    $routes->put('categories/(:num)', 'BlogAdminApiController::updateCategory/$1');
    $routes->delete('categories/(:num)', 'BlogAdminApiController::deleteCategory/$1');
    
    // Tags CRUD
    $routes->get('tags', 'BlogAdminApiController::tags');
    $routes->post('tags', 'BlogAdminApiController::createTag');
    $routes->delete('tags/(:num)', 'BlogAdminApiController::deleteTag/$1');
    
    // AI Features
    $routes->post('ai/generate-summary', 'BlogAdminApiController::generateSummary');
    $routes->post('ai/extract-keywords', 'BlogAdminApiController::extractKeywords');
    
    // Statistics
    $routes->get('stats', 'BlogAdminApiController::stats');
});

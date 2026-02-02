<?php
/**
 * Route Test Script
 * Place in project root and run: php test_route.php
 */

// Load CodeIgniter
require __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
$app = require_once FCPATH . '../app/Config/Paths.php';
$app = new \CodeIgniter\CodeIgniter($app);
$app->initialize();

// Get routes
$routes = service('routes');
$collection = $routes->getRoutes();

echo "=== Checking Routes ===\n\n";

// Check if our route exists
$found = false;
foreach ($collection as $route => $handler) {
    if (strpos($route, 'writable/uploads') !== false) {
        echo "✓ Found route: $route => $handler\n";
        $found = true;
    }
}

if (!$found) {
    echo "✗ Route 'writable/uploads/(.+)' NOT FOUND!\n";
    echo "\nThis is the problem! The route is not being registered.\n";
}

echo "\n=== Testing File Access ===\n\n";

// Check if files exist
$uploadsPath = WRITEPATH . 'uploads/programs/thumbs/';
echo "Upload path: $uploadsPath\n";
echo "Exists: " . (is_dir($uploadsPath) ? 'YES' : 'NO') . "\n";

if (is_dir($uploadsPath)) {
    $files = array_diff(scandir($uploadsPath), ['.', '..']);
    echo "Files found: " . count($files) . "\n";
    
    if (!empty($files)) {
        $testFile = reset($files);
        echo "\nTest file: $testFile\n";
        $fullPath = $uploadsPath . $testFile;
        echo "Full path: $fullPath\n";
        echo "Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
        echo "Readable: " . (is_readable($fullPath) ? 'YES' : 'NO') . "\n";
        echo "Size: " . filesize($fullPath) . " bytes\n";
    }
}

echo "\n=== FileController Check ===\n\n";

$controllerPath = APPPATH . 'Controllers/FileController.php';
echo "FileController exists: " . (file_exists($controllerPath) ? 'YES' : 'NO') . "\n";

if (file_exists($controllerPath)) {
    echo "FileController path: $controllerPath\n";
}

echo "\n=== Recommendations ===\n\n";

if (!$found) {
    echo "1. The route is not being loaded properly\n";
    echo "2. Try moving the route AFTER the module routes in Routes.php\n";
    echo "3. Or add it to a module route file instead\n";
}

echo "\nDone!\n";

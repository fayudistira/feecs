<?php
// Simple performance test
$start = microtime(true);

// Test 1: Autoloader
require __DIR__ . '/vendor/autoload.php';
$autoload_time = microtime(true) - $start;
echo "Autoload time: " . number_format($autoload_time * 1000, 2) . "ms\n";

// Test 2: Database connection
$start = microtime(true);
$db = mysqli_connect('localhost', 'root', '', 'feecs', 3306);
$db_time = microtime(true) - $start;
echo "DB Connect time: " . number_format($db_time * 1000, 2) . "ms\n";

// Test 3: Query programs
$start = microtime(true);
$result = mysqli_query($db, "SELECT * FROM programs WHERE status = 'active' AND deleted_at IS NULL");
$programs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $programs[] = $row;
}
$query_time = microtime(true) - $start;
echo "Query time: " . number_format($query_time * 1000, 2) . "ms\n";
echo "Programs found: " . count($programs) . "\n";

mysqli_close($db);

// Test 4: Check if composer packages are slow
$start = microtime(true);
$packages = require __DIR__ . '/vendor/composer/installed.php';
$composer_time = microtime(true) - $start;
echo "Composer packages time: " . number_format($composer_time * 1000, 2) . "ms\n";
echo "Total packages: " . count($packages['versions']) . "\n";

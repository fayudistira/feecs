<?php
/**
 * Script to fix blog migration by adding migration record manually
 * and check existing tables
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/app/Config/Bootstrap.php';
$app->initialize();

$db = \Config\Database::connect();

// Check if tables exist
$tables = ['blog_posts', 'blog_categories', 'blog_tags', 'blog_post_tags', 'blog_settings'];

echo "Checking existing tables:\n";
foreach ($tables as $table) {
    $query = $db->query("SHOW TABLES LIKE '{$table}'");
    $exists = count($query->getResult()) > 0;
    echo "  {$table}: " . ($exists ? "EXISTS" : "NOT EXISTS") . "\n";
}

// Add migration record if not exists
echo "\nAdding migration record...\n";
$check = $db->query("SELECT * FROM migrations WHERE version = '2026-03-04-185159' AND class = 'CreateBlogTables'");
if (count($check->getResult()) == 0) {
    $db->query("INSERT INTO migrations (version, class, group, namespace, time) VALUES ('2026-03-04-185159', 'CreateBlogTables', 'default', 'App', UNIX_TIMESTAMP())");
    echo "Migration record added successfully.\n";
} else {
    echo "Migration record already exists.\n";
}

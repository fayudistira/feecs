<?php
require 'vendor/autoload.php';
$app = require_once 'app/Config/Paths.php';
require_once 'system/Test/bootstrap.php';

$db = \Config\Database::connect();
$results = $db->table('programs')->select('category, sub_category')->groupBy('category, sub_category')->get()->getResultArray();
print_r($results);

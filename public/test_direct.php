<?php
// Direct test bypassing CodeIgniter
echo "Testing direct database access...\n";

$start = microtime(true);
$db = mysqli_connect('localhost', 'root', '', 'feecs', 3306);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($db, "SELECT * FROM programs WHERE status = 'active' AND deleted_at IS NULL");
$programs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $programs[] = $row;
}
$time = microtime(true) - $start;

echo "Query time: " . number_format($time * 1000, 2) . "ms\n";
echo "Programs found: " . count($programs) . "\n";
echo "✓ Database is fast!\n";

mysqli_close($db);

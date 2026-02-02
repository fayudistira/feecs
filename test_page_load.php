<?php
echo "Testing page load...\n";

$start = microtime(true);
$ch = curl_init('http://localhost:8080/programs');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$time = microtime(true) - $start;
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $code\n";
echo "Load time: " . number_format($time * 1000, 2) . "ms\n";
echo "Response size: " . strlen($result) . " bytes\n";

if ($code == 200) {
    echo "✓ Page loaded successfully!\n";
} else {
    echo "✗ Page failed to load\n";
}

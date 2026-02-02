<?php
echo "Testing simple HTTP request...\n";

$start = microtime(true);
$ch = curl_init('http://localhost:8080/about');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$result = curl_exec($ch);
$time = microtime(true) - $start;
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "cURL Error: $error\n";
}

echo "HTTP Code: $code\n";
echo "Load time: " . number_format($time * 1000, 2) . "ms\n";
echo "Response size: " . strlen($result) . " bytes\n";

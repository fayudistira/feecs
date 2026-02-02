<?php
/**
 * Thumbnail Debug Script
 * Place this in your public directory and access it directly
 * URL: https://yourdomain.com/debug_thumbnails.php
 */

echo "<h1>Thumbnail Debug Information</h1>";
echo "<style>body{font-family:Arial;margin:20px;} .error{color:red;} .success{color:green;} pre{background:#f4f4f4;padding:10px;}</style>";

// 1. Check if writable directory exists
$writablePath = dirname(__DIR__) . '/writable/uploads/programs/thumbs/';
echo "<h2>1. Directory Check</h2>";
echo "<strong>Path:</strong> " . $writablePath . "<br>";
echo "<strong>Exists:</strong> " . (is_dir($writablePath) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";
echo "<strong>Readable:</strong> " . (is_readable($writablePath) ? '<span class="success">YES</span>' : '<span class="error">NO</span>') . "<br>";

// 2. List files
echo "<h2>2. Files in Directory</h2>";
if (is_dir($writablePath)) {
    $files = array_diff(scandir($writablePath), ['.', '..']);
    if (empty($files)) {
        echo "<p class='error'>No files found!</p>";
    } else {
        echo "<p>Found " . count($files) . " file(s):</p>";
        echo "<ul>";
        foreach (array_slice($files, 0, 5) as $file) {
            $fullPath = $writablePath . $file;
            echo "<li><strong>$file</strong> - " . filesize($fullPath) . " bytes - Readable: " . (is_readable($fullPath) ? 'YES' : 'NO') . "</li>";
        }
        echo "</ul>";
        
        // 3. Test different URL patterns
        if (!empty($files)) {
            $testFile = reset($files);
            echo "<h2>3. Testing Different URL Patterns for: $testFile</h2>";
            
            $patterns = [
                'Pattern 1 (Direct - SHOULD FAIL)' => "../writable/uploads/programs/thumbs/$testFile",
                'Pattern 2 (Via Route - SHOULD WORK)' => "/writable/uploads/programs/thumbs/$testFile",
                'Pattern 3 (Full base_url)' => "https://" . $_SERVER['HTTP_HOST'] . "/writable/uploads/programs/thumbs/$testFile",
            ];
            
            foreach ($patterns as $label => $url) {
                echo "<h3>$label</h3>";
                echo "<p>URL: <code>$url</code></p>";
                echo "<img src='$url' alt='$label' style='max-width:200px; border:2px solid #ccc; margin:10px 0;' onerror=\"this.style.border='2px solid red'; this.alt='FAILED: $label';\">";
                echo "<br><br>";
            }
        }
    }
} else {
    echo "<p class='error'>Directory does not exist!</p>";
}

// 4. Check .htaccess
echo "<h2>4. Check .htaccess</h2>";
$htaccessPath = __DIR__ . '/.htaccess';
if (file_exists($htaccessPath)) {
    echo "<p class='success'>.htaccess exists</p>";
    echo "<pre>" . htmlspecialchars(file_get_contents($htaccessPath)) . "</pre>";
} else {
    echo "<p class='error'>.htaccess NOT found!</p>";
}

// 5. Test FileController route
echo "<h2>5. Test FileController Route</h2>";
if (!empty($files)) {
    $testFile = reset($files);
    $testUrl = "/writable/uploads/programs/thumbs/$testFile";
    
    echo "<p>Testing URL: <code>$testUrl</code></p>";
    
    // Use cURL to test
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://" . $_SERVER['HTTP_HOST'] . $testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "<p><strong>HTTP Status:</strong> ";
    if ($httpCode == 200) {
        echo "<span class='success'>$httpCode OK - Route is working!</span>";
    } elseif ($httpCode == 404) {
        echo "<span class='error'>$httpCode NOT FOUND - Route is not working!</span>";
    } elseif ($httpCode == 403) {
        echo "<span class='error'>$httpCode FORBIDDEN - Permission issue!</span>";
    } else {
        echo "<span class='error'>$httpCode - Unexpected response!</span>";
    }
    echo "</p>";
    
    echo "<h3>Response Headers:</h3>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}

// 6. Check Routes.php
echo "<h2>6. Check Routes Configuration</h2>";
$routesPath = dirname(__DIR__) . '/app/Config/Routes.php';
if (file_exists($routesPath)) {
    $routesContent = file_get_contents($routesPath);
    if (strpos($routesContent, "writable/uploads") !== false) {
        echo "<p class='success'>Route for writable/uploads found in Routes.php</p>";
        
        // Extract the route line
        preg_match('/\$routes->get\([\'"]writable\/uploads.*?\);/s', $routesContent, $matches);
        if (!empty($matches)) {
            echo "<pre>" . htmlspecialchars($matches[0]) . "</pre>";
        }
    } else {
        echo "<p class='error'>Route for writable/uploads NOT found in Routes.php!</p>";
        echo "<p>Add this line to app/Config/Routes.php:</p>";
        echo "<pre>\$routes->get('writable/uploads/(.+)', 'FileController::serve/\$1');</pre>";
    }
}

// 7. Server info
echo "<h2>7. Server Information</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><td>Server Software</td><td>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>PHP Version</td><td>" . phpversion() . "</td></tr>";
echo "<tr><td>Document Root</td><td>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "<tr><td>Script Path</td><td>" . __FILE__ . "</td></tr>";
echo "<tr><td>Base URL</td><td>https://" . $_SERVER['HTTP_HOST'] . "</td></tr>";
echo "</table>";

echo "<hr>";
echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>If Pattern 2 (Via Route) shows the image, your setup is correct</li>";
echo "<li>If HTTP Status is 404, the route is not configured properly</li>";
echo "<li>If HTTP Status is 403, it's a permission issue (but you said 777 is set)</li>";
echo "<li>Check your browser console (F12) for any JavaScript errors</li>";
echo "<li>Check if base_url() in your app is configured correctly</li>";
echo "</ol>";

echo "<p><strong>⚠️ DELETE THIS FILE AFTER DEBUGGING!</strong></p>";
?>

<?php
/**
 * Direct Image Test
 * Access: https://yourdomain.com/test_image.php?file=filename.png
 * This bypasses CodeIgniter routing to test if files are accessible
 */

$filename = $_GET['file'] ?? '';

if (empty($filename)) {
    die('Usage: test_image.php?file=filename.png');
}

// Construct path
$uploadsPath = dirname(__DIR__) . '/writable/uploads/programs/thumbs/';
$filePath = $uploadsPath . basename($filename); // basename for security

echo "<h1>Direct File Access Test</h1>";
echo "<p><strong>Testing file:</strong> " . htmlspecialchars($filename) . "</p>";
echo "<p><strong>Full path:</strong> " . htmlspecialchars($filePath) . "</p>";

// Check if file exists
if (!file_exists($filePath)) {
    echo "<p style='color:red;'>❌ File does NOT exist at this path!</p>";
    echo "<p>Files in directory:</p>";
    if (is_dir($uploadsPath)) {
        $files = array_diff(scandir($uploadsPath), ['.', '..']);
        echo "<ul>";
        foreach ($files as $f) {
            echo "<li>" . htmlspecialchars($f) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>Directory does not exist!</p>";
    }
    exit;
}

echo "<p style='color:green;'>✓ File exists!</p>";
echo "<p><strong>File size:</strong> " . filesize($filePath) . " bytes</p>";
echo "<p><strong>Readable:</strong> " . (is_readable($filePath) ? 'YES' : 'NO') . "</p>";

// Get mime type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $filePath);
finfo_close($finfo);
echo "<p><strong>MIME type:</strong> " . htmlspecialchars($mimeType) . "</p>";

// Display the image
echo "<h2>Direct Display (bypassing CodeIgniter):</h2>";
echo "<img src='data:" . $mimeType . ";base64," . base64encode(file_get_contents($filePath)) . "' style='max-width:400px; border:2px solid green;'>";

echo "<h2>Via CodeIgniter Route:</h2>";
echo "<img src='/writable/uploads/programs/thumbs/" . htmlspecialchars($filename) . "' style='max-width:400px; border:2px solid blue;' onerror=\"this.style.border='2px solid red'; this.alt='FAILED TO LOAD VIA ROUTE';\">";

echo "<hr>";
echo "<p><strong>If the first image shows but the second doesn't, the issue is with CodeIgniter routing.</strong></p>";
echo "<p><strong>⚠️ DELETE THIS FILE AFTER TESTING!</strong></p>";
?>

<?php
/**
 * AGGRESSIVE THUMBNAIL DEBUG
 * This will tell us EXACTLY what's wrong
 * Access: https://yourdomain.com/test_thumbnail.php
 * DELETE AFTER USE!
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thumbnail Debug Test</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #f5f5f5; }
        .test { background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #ccc; }
        .pass { border-left-color: green; }
        .fail { border-left-color: red; }
        .warn { border-left-color: orange; }
        h2 { margin: 0 0 10px 0; }
        pre { bac
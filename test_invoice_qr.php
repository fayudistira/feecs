<?php
// Simple test file to check invoice QR and public view
// Access this file at: http://localhost/test_invoice_qr.php

echo "<h1>Invoice QR Code and Public View Test</h1>";

$invoiceId = 1; // Test with invoice ID 1
$baseUrl = "http://localhost/feecs"; // Adjust this to your base URL

echo "<h2>Test Links:</h2>";
echo "<ul>";
echo "<li><a href='{$baseUrl}/invoice/view/{$invoiceId}' target='_blank'>Admin Invoice View (ID: {$invoiceId}) - Requires Login</a></li>";
echo "<li><a href='{$baseUrl}/invoice/public/{$invoiceId}' target='_blank'>Public Invoice View (ID: {$invoiceId}) - No Login Required</a></li>";
echo "</ul>";

echo "<h2>Expected Behavior:</h2>";
echo "<ul>";
echo "<li><strong>Admin View:</strong> QR code generated with JavaScript in sidebar</li>";
echo "<li><strong>Public View:</strong> QR code generated with JavaScript at bottom of page</li>";
echo "<li><strong>PDF Download:</strong> QR code embedded as image in PDF file</li>";
echo "<li>Scanning any QR code should open the public invoice view</li>";
echo "<li>QR codes use dark red color (#8B0000) to match theme</li>";
echo "</ul>";

echo "<h2>Technology Used:</h2>";
echo "<ul>";
echo "<li><strong>Client-side:</strong> QRCode.js library (JavaScript)</li>";
echo "<li><strong>Server-side (PDF):</strong> endroid/qr-code (PHP)</li>";
echo "<li><strong>Benefits:</strong> Faster loading, no server requests for web views</li>";
echo "</ul>";
?>

<?php

require_once __DIR__ . '/vendor/autoload.php';

// Test email configuration and secure tokens
echo "Testing Email Configuration & Secure Tokens...\n\n";

try {
    // Load email configuration
    $config = config('Email');
    echo "✓ Email configuration loaded\n";
    echo "  From Email: " . $config->fromEmail . "\n";
    echo "  From Name: " . $config->fromName . "\n";
    echo "  SMTP Host: " . $config->SMTPHost . "\n";
    echo "  SMTP Port: " . $config->SMTPPort . "\n";
    echo "  SMTP User: " . $config->SMTPUser . "\n";
    echo "  Protocol: " . $config->protocol . "\n";
    echo "  SMTP Crypto: " . $config->SMTPCrypto . "\n\n";

    // Test EmailService
    $emailService = new \App\Services\EmailService();
    echo "✓ EmailService created\n\n";

    // Test token generation
    echo "Testing secure token generation...\n";
    $testInvoiceId = 123;
    $testEmail = 'test@example.com';
    $token = $emailService->generateInvoiceToken($testInvoiceId, $testEmail);
    echo "✓ Token generated: " . substr($token, 0, 20) . "...\n";

    // Test token verification
    echo "Testing token verification...\n";
    $decoded = $emailService->verifyInvoiceToken($token);
    if ($decoded) {
        echo "✓ Token verified successfully\n";
        echo "  Invoice ID: " . $decoded['invoice_id'] . "\n";
        echo "  Email: " . $decoded['email'] . "\n";
        echo "  Timestamp: " . date('Y-m-d H:i:s', $decoded['timestamp']) . "\n";
    } else {
        echo "✗ Token verification failed\n";
    }

    // Test invalid token
    echo "\nTesting invalid token...\n";
    $invalidToken = 'invalid_token_here';
    $invalidResult = $emailService->verifyInvoiceToken($invalidToken);
    if (!$invalidResult) {
        echo "✓ Invalid token correctly rejected\n";
    } else {
        echo "✗ Invalid token was accepted\n";
    }

    // Test expired token (simulate by setting old timestamp)
    echo "\nTesting expired token...\n";
    $oldData = [
        'invoice_id' => $testInvoiceId,
        'email' => $testEmail,
        'timestamp' => time() - 86401, // 1 second over 24 hours
        'hash' => hash('sha256', $testInvoiceId . $testEmail . (time() - 86401) . 'invoice_salt')
    ];
    $oldToken = $emailService->encryption->encrypt(json_encode($oldData));
    $expiredResult = $emailService->verifyInvoiceToken($oldToken);
    if (!$expiredResult) {
        echo "✓ Expired token correctly rejected\n";
    } else {
        echo "✗ Expired token was accepted\n";
    }

    echo "\n" . str_repeat("-", 50) . "\n";

    // Test email sending with sample data
    echo "Testing invoice email with secure link...\n";

    $invoice = [
        'amount' => 500000,
        'due_date' => '2026-02-09',
        'description' => 'Registration Fee for Computer Science'
    ];

    $admissionData = [
        'registration_number' => 'REG-2026-TEST',
        'program_title' => 'Computer Science'
    ];

    echo "Note: This will attempt to send an email to test@example.com\n";
    echo "Check your email for the secure invoice link.\n\n";

    $result = $emailService->sendInvoiceNotification(
        $invoice,
        'test@example.com', // Replace with your actual test email
        'Test User',
        $admissionData,
        $testInvoiceId
    );

    if ($result) {
        echo "✓ Email sent successfully!\n";
        echo "✓ Check your email for the secure invoice link\n";
    } else {
        echo "✗ Email failed to send\n";
        echo "Check the logs for details\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nTest completed.\n";

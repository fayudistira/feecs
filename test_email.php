<?php

require_once __DIR__ . '/vendor/autoload.php';

// Test email configuration
echo "Testing Email Configuration...\n\n";

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

    // Test email sending with sample data
    $invoice = [
        'amount' => 500000,
        'due_date' => '2026-02-09',
        'description' => 'Registration Fee for Computer Science'
    ];

    $admissionData = [
        'registration_number' => 'REG-2026-TEST',
        'program_title' => 'Computer Science'
    ];

    echo "Testing invoice email...\n";

    $result = $emailService->sendInvoiceNotification(
        $invoice,
        'test@example.com', // Replace with your test email
        'Test User',
        $admissionData,
        123 // Test invoice ID
    );

    if ($result) {
        echo "✓ Email sent successfully!\n";
    } else {
        echo "✗ Email failed to send\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";

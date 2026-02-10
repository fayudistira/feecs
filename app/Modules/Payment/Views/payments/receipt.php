<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt #<?= esc($payment['payment_number']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #8B0000;
        }

        .company-info h1 {
            margin: 0;
            color: #8B0000;
            font-size: 24px;
        }

        .company-info p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }

        .receipt-title {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #333;
        }

        .receipt-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .receipt-meta .left,
        .receipt-meta .right {
            flex: 1;
        }

        .receipt-meta .right {
            text-align: right;
        }

        .receipt-meta p {
            margin: 5px 0;
            font-size: 14px;
        }

        .receipt-details {
            margin-bottom: 20px;
        }

        .receipt-details h4 {
            margin: 0 0 10px 0;
            color: #8B0000;
            font-size: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .detail-label {
            flex: 1;
            color: #555;
        }

        .detail-value {
            flex: 1;
            font-weight: 600;
            color: #333;
        }

        .payment-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .payment-info h4 {
            margin: 0 0 10px 0;
            color: #8B0000;
            font-size: 16px;
        }

        .payment-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .amount-box {
            background: linear-gradient(135deg, #FFE5E5 0%, #fff 100%);
            border: 2px solid #8B0000;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
        }

        .amount-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 24px;
            font-weight: bold;
            color: #8B0000;
        }

        .receipt-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .qr-code {
            margin: 20px 0;
            text-align: center;
        }

        .qr-code img {
            max-width: 100px;
        }

        .qr-code p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }

        .payment-summary {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .payment-summary h4 {
            margin: 0 0 15px 0;
            color: #8B0000;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .summary-label {
            color: #555;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
        }

        .summary-value.highlight {
            color: #8B0000;
        }

        .progress {
            height: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #8B0000, #6B0000);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 600;
            transition: width 0.3s ease;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                margin: 0;
                border: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="company-info">
                <h1>SOSCT</h1>
                <p>SOS Course & Training</p>
                <p><?= esc($company['address']) ?></p>
                <p><?= esc($company['email']) ?> | <?= esc($company['phone']) ?></p>
            </div>
        </div>

        <!-- Receipt Title -->
        <div class="receipt-title">PAYMENT RECEIPT</div>

        <!-- Receipt Meta -->
        <div class="receipt-meta">
            <div class="left">
                <p><strong>Receipt #:</strong> <?= esc($payment['payment_number']) ?></p>
                <p><strong>Date:</strong> <?= date('F d, Y', strtotime($payment['payment_date'])) ?></p>
            </div>
            <div class="right">
                <p><strong>Time:</strong> <?= date('H:i', strtotime($payment['created_at'])) ?></p>
                <p><strong>Payment Method:</strong> <?= ucwords(str_replace('_', ' ', $payment['payment_method'])) ?></p>
            </div>
        </div>

        <!-- Student Information -->
        <div class="receipt-details">
            <h4>Student Information</h4>
            <div class="detail-row">
                <div class="detail-label">Name:</div>
                <div class="detail-value"><?= esc($student['full_name']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Registration No:</div>
                <div class="detail-value"><?= esc($invoice['registration_number']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value"><?= esc($student['email']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Phone:</div>
                <div class="detail-value"><?= esc($student['phone']) ?></div>
            </div>
        </div>

        <!-- Invoice Information -->
        <div class="receipt-details">
            <h4>Invoice Information</h4>
            <div class="detail-row">
                <div class="detail-label">Invoice #:</div>
                <div class="detail-value"><?= esc($invoice['invoice_number']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Invoice Type:</div>
                <div class="detail-value"><?= ucwords(str_replace('_', ' ', $invoice['invoice_type'])) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Program:</div>
                <div class="detail-value"><?= esc($student['program_title']) ?></div>
            </div>
        </div>

        <!-- Payment Summary -->
        <?php if ($invoice): ?>
            <?php
            $totalAmount = (float)($invoice['amount'] ?? 0);
            $totalPaid = (float)($invoice['total_paid'] ?? 0);
            $remainingBalance = $totalAmount - $totalPaid;
            $progress = $totalAmount > 0 ? ($totalPaid / $totalAmount * 100) : 0;
            ?>
            <div class="payment-summary">
                <h4>Payment Summary</h4>
                <div class="summary-row">
                    <span class="summary-label">Total Amount:</span>
                    <span class="summary-value">Rp <?= number_format($totalAmount, 0, ',', '.') ?></span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Total Paid:</span>
                    <span class="summary-value highlight">Rp <?= number_format($totalPaid, 0, ',', '.') ?></span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Remaining Balance:</span>
                    <span class="summary-value">Rp <?= number_format($remainingBalance, 0, ',', '.') ?></span>
                </div>
                <div class="summary-row" style="margin-top: 10px;">
                    <span class="summary-label">Payment Progress:</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: <?= min($progress, 100) ?>%;">
                        <?= number_format($progress, 1) ?>%
                    </div>
                </div>
            </div>
        <?php endif ?>

        <!-- Payment Information -->
        <div class="payment-info">
            <h4>Payment Details</h4>
            <div class="detail-row">
                <div class="detail-label">Payment Status:</div>
                <div class="detail-value">
                    <span class="badge bg-success">Paid</span>
                </div>
            </div>
            <?php if (!empty($payment['transaction_id'])): ?>
                <div class="detail-row">
                    <div class="detail-label">Transaction ID:</div>
                    <div class="detail-value"><?= esc($payment['transaction_id']) ?></div>
                </div>
            <?php endif ?>
            <?php if (!empty($payment['notes'])): ?>
                <div class="detail-row">
                    <div class="detail-label">Notes:</div>
                    <div class="detail-value"><?= nl2br(esc((string)$payment['notes'])) ?></div>
                </div>
            <?php endif ?>
        </div>

        <!-- Amount -->
        <div class="amount-box">
            <div class="amount-label">Amount Paid</div>
            <div class="amount-value">Rp <?= number_format($payment['amount'], 0, ',', '.') ?></div>
        </div>

        <!-- QR Code -->
        <div class="qr-code">
            <img src="<?= base_url('payment/qr/' . $payment['id']) ?>" alt="QR Code" width="100" height="100">
            <p>Scan to verify payment</p>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <p>This is a computer-generated receipt. No signature required.</p>
            <p>Thank you for your payment!</p>
        </div>
    </div>
</body>

</html>
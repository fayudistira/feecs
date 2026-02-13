<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Modules\Payment\Models\InvoiceModel;
use Modules\Payment\Models\PaymentModel;
use Modules\Payment\Models\InstallmentModel;

class LinkPaymentsToInstallments extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'payments:link-installments';
    protected $description = 'Link existing payments to their installments based on invoice relationships';

    public function run(array $params)
    {
        $invoiceModel = new InvoiceModel();
        $paymentModel = new PaymentModel();
        $installmentModel = new InstallmentModel();

        CLI::write('Starting to link payments to installments...', 'green');

        // Get all payments without installment_id
        $payments = $paymentModel->where('installment_id', null)->findAll();

        $linked = 0;
        $skipped = 0;

        foreach ($payments as $payment) {
            if (empty($payment['invoice_id'])) {
                CLI::write("Payment #{$payment['id']}: No invoice, skipping...", 'yellow');
                $skipped++;
                continue;
            }

            // Get the invoice
            $invoice = $invoiceModel->find($payment['invoice_id']);

            if (!$invoice) {
                CLI::write("Payment #{$payment['id']}: Invoice not found, skipping...", 'yellow');
                $skipped++;
                continue;
            }

            if (empty($invoice['installment_id'])) {
                CLI::write("Payment #{$payment['id']}: Invoice #{$invoice['id']} has no installment, skipping...", 'yellow');
                $skipped++;
                continue;
            }

            // Update the payment with installment_id
            $paymentModel->update($payment['id'], [
                'installment_id' => $invoice['installment_id']
            ]);

            CLI::write("Payment #{$payment['id']}: Linked to installment #{$invoice['installment_id']}", 'green');
            $linked++;
        }

        CLI::write("Done! Linked: {$linked}, Skipped: {$skipped}", 'green');

        // Now update all installments with correct totals
        CLI::write("\nUpdating installment totals...", 'green');

        $installments = $installmentModel->findAll();
        $updated = 0;

        foreach ($installments as $installment) {
            $installmentModel->updatePaymentTotal($installment['id']);
            $updated++;
        }

        CLI::write("Updated {$updated} installments!", 'green');
    }
}

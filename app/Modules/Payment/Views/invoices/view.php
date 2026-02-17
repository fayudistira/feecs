<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<style>
    .invoice-header {
        background: linear-gradient(to right, #8B0000, #6B0000);
        color: white;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .info-label {
        font-weight: bold;
        color: #8B0000;
    }
</style>

<div class="container-fluid">
    <div class="invoice-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-0">Faktur <?= esc($invoice['invoice_number']) ?></h3>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?= base_url('invoice/pdf/' . $invoice['id']) ?>" class="btn btn-light" target="_blank">
                    <i class="bi bi-file-pdf"></i> Unduh PDF
                </a>
                <?php if (in_array($invoice['status'], ['unpaid', 'expired'])): ?>
                    <a href="<?= base_url('invoice/cancel/' . $invoice['id']) ?>" class="btn btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin membatalkan faktur ini? Tindakan ini tidak dapat dibatalkan.')">
                        <i class="bi bi-x-circle"></i> Batalkan Faktur
                    </a>
                <?php endif; ?>
                <a href="<?= base_url('invoice') ?>" class="btn btn-outline-light">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header" style="background-color: #8B0000; color: white;">
                    <h5 class="mb-0">Detail Faktur</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="info-label">Nomor Faktur:</span> <?= esc($invoice['invoice_number']) ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Jenis:</span> <?= ucwords(str_replace('_', ' ', $invoice['invoice_type'])) ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Jumlah:</span> Rp <?= number_format($invoice['amount'], 0, ',', '.') ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Tanggal Jatuh Tempo:</span> <?= date('F d, Y', strtotime($invoice['due_date'])) ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Status:</span>
                        <span class="badge bg-<?php
                                                if ($invoice['status'] === 'paid') echo 'success';
                                                elseif ($invoice['status'] === 'partially_paid') echo 'info';
                                                elseif ($invoice['status'] === 'unpaid') echo 'warning';
                                                elseif ($invoice['status'] === 'expired') echo 'danger';
                                                elseif ($invoice['status'] === 'extended') echo 'primary';
                                                else echo 'secondary';
                                                ?>">
                            <?= str_replace('_', ' ', ucfirst($invoice['status'])) ?>
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Deskripsi:</span><br>
                        <?= nl2br(esc((string)($invoice['description'] ?? ''))) ?>
                    </div>
                    
                    <?php if (!empty($parentInvoice)): ?>
                        <div class="mt-3 pt-3 border-top">
                            <span class="info-label"><i class="bi bi-arrow-left-circle"></i> Faktur Asli (Diperpanjang):</span>
                            <div class="mt-2">
                                <a href="<?= base_url('invoice/view/' . $parentInvoice['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark"></i> <?= esc($parentInvoice['invoice_number']) ?>
                                </a>
                                <small class="text-muted ms-2">
                                    Rp <?= number_format($parentInvoice['amount'], 0, ',', '.') ?> - 
                                    <span class="badge bg-primary">Extended</span>
                                </small>
                            </div>
                        </div>
                    <?php endif ?>
                    
                    <?php if (!empty($childInvoice)): ?>
                        <div class="mt-3 pt-3 border-top">
                            <span class="info-label"><i class="bi bi-arrow-right-circle"></i> Faktur Perpanjangan:</span>
                            <div class="mt-2">
                                <a href="<?= base_url('invoice/view/' . $childInvoice['id']) ?>" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-plus"></i> <?= esc($childInvoice['invoice_number']) ?>
                                </a>
                                <small class="text-muted ms-2">
                                    Rp <?= number_format($childInvoice['amount'], 0, ',', '.') ?> - 
                                    <span class="badge bg-<?= $childInvoice['status'] === 'paid' ? 'success' : ($childInvoice['status'] === 'unpaid' ? 'warning' : 'info') ?>">
                                        <?= ucfirst($childInvoice['status']) ?>
                                    </span>
                                </small>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>

            <?php if ($invoice['status'] === 'partially_paid' || !empty($invoice['total_paid'])): ?>
                <div class="card mb-3">
                    <div class="card-header" style="background-color: #8B0000; color: white;">
                        <h5 class="mb-0">Ringkasan Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="info-label">Total Jumlah:</span> Rp <?= number_format($invoice['amount'], 0, ',', '.') ?>
                        </div>
                        <div class="mb-2">
                            <span class="info-label">Total Dibayar:</span> Rp <?= number_format($invoice['total_paid'] ?? 0, 0, ',', '.') ?>
                        </div>
                        <div class="mb-2">
                            <span class="info-label">Sisa Saldo:</span>
                            <span class="badge bg-warning">Rp <?= number_format(($invoice['amount'] ?? 0) - ($invoice['total_paid'] ?? 0), 0, ',', '.') ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="info-label">Progres Pembayaran:</span>
                            <div class="progress" style="height: 20px;">
                                <?php
                                $progress = ($invoice['total_paid'] ?? 0) / ($invoice['amount'] ?? 1) * 100;
                                $progress = min($progress, 100);
                                ?>
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= number_format($progress, 1) ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header" style="background-color: #8B0000; color: white;">
                    <h5 class="mb-0">Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="info-label">Nama:</span> <?= esc($invoice['student']['full_name'] ?? 'N/A') ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Nomor Registrasi:</span> <?= esc($invoice['registration_number']) ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Email:</span> <?= esc($invoice['student']['email'] ?? 'N/A') ?>
                    </div>
                    <div class="mb-2">
                        <span class="info-label">Telepon:</span> <?= esc($invoice['student']['phone'] ?? 'N/A') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($invoice['payments'])): ?>
        <div class="card">
            <div class="card-header" style="background-color: #8B0000; color: white;">
                <h5 class="mb-0">Pembayaran Terkait</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoice['payments'] as $payment): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($payment['payment_date'])) ?></td>
                                <td>Rp <?= number_format($payment['amount'], 0, ',', '.') ?></td>
                                <td><?= ucwords(str_replace('_', ' ', $payment['payment_method'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $payment['status'] === 'paid' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($payment['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
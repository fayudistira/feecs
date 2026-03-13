<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-upload me-2"></i>Unggah Massal Items</h4>
    <a href="/inventory/items" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Unggah File Excel</h5>
            </div>
            <div class="card-body">
                <form method="post" action="/inventory/items/process-upload" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel (.xlsx, .xls)</label>
                        <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls" required>
                        <small class="text-muted">Maksimal ukuran file: 5MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Opsi Pengunggahan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="update_existing" id="skipExisting" value="0" checked>
                            <label class="form-check-label" for="skipExisting">
                                Lewati item yang sudah ada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="update_existing" id="updateExisting" value="1">
                            <label class="form-check-label" for="updateExisting">
                                Perbarui item yang sudah ada
                            </label>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="/inventory/items/template" class="btn btn-outline-primary" target="_blank">
                            <i class="bi bi-download me-1"></i> Download Template
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Unggah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Panduan Pengunggahan</h5>
            </div>
            <div class="card-body">
                <h6>Kolom yang Diperlukan:</h6>
                <ul>
                    <li><strong>name</strong> - Nama item (wajib)</li>
                    <li><strong>item_code</strong> - Kode item (jika kosong, akan dibuat otomatis)</li>
                    <li><strong>barcode</strong> - Barcode (opsional)</li>
                </ul>

                <h6>Kolom Opsional:</h6>
                <ul>
                    <li><strong>description</strong> - Deskripsi item</li>
                    <li><strong>category_name</strong> - Nama kategori (akan dicocokkan dengan data yang ada)</li>
                    <li><strong>location_name</strong> - Nama lokasi (akan dicocokkan dengan data yang ada)</li>
                    <li><strong>unit</strong> - Satuan (piece, box, pack, set, kg, liter, meter)</li>
                    <li><strong>purchase_price</strong> - Harga beli</li>
                    <li><strong>selling_price</strong> - Harga jual</li>
                    <li><strong>current_stock</strong> - Stok saat ini</li>
                    <li><strong>minimum_stock</strong> - Stok minimum</li>
                    <li><strong>maximum_stock</strong> - Stok maksimum</li>
                    <li><strong>supplier_id</strong> - ID Supplier</li>
                    <li><strong>supplier_name</strong> - Nama Supplier</li>
                    <li><strong>status</strong> - Status (active, inactive, discontinued)</li>
                </ul>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Kategori dan Lokasi akan dicocokkan berdasarkan nama. Jika tidak ditemukan, akan menggunakan nilai default.
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($results)): ?>
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Hasil Pengunggahan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="alert alert-success">
                    <strong><?= $results['success'] ?? 0 ?></strong> item berhasil diproses
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-warning">
                    <strong><?= $results['skipped'] ?? 0 ?></strong> item dilewati
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-danger">
                    <strong><?= $results['errors'] ?? 0 ?></strong> item gagal
                </div>
            </div>
        </div>

        <?php if (!empty($results['error_details'])): ?>
        <h6>Detail Error:</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Baris</th>
                        <th>Item</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results['error_details'] as $error): ?>
                    <tr>
                        <td><?= $error['row'] ?></td>
                        <td><?= $error['name'] ?? '-' ?></td>
                        <td><?= $error['message'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

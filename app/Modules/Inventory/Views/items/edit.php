<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Barang</h4>
            <a href="/inventory/items" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post" action="/inventory/items/update/<?= $item['id'] ?>">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" name="item_code" class="form-control" value="<?= $item['item_code'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Barcode</label>
                                <input type="text" name="barcode" class="form-control" value="<?= $item['barcode'] ?? '' ?>" placeholder="Otomatis dibuat jika kosong">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="name" class="form-control" value="<?= $item['name'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"><?= $item['description'] ?? '' ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= (isset($item['category_id']) && $item['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <select name="location_id" class="form-select">
                                    <option value="">Pilih Lokasi</option>
                                    <?php foreach($locations as $loc): ?>
                                    <option value="<?= $loc['id'] ?>" <?= (isset($item['location_id']) && $item['location_id'] == $loc['id']) ? 'selected' : '' ?>><?= $loc['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Program Terintegrasi</label>
                                <select name="program_id" class="form-select">
                                    <option value="">Tanpa Program</option>
                                    <?php foreach($programs as $prog): ?>
                                    <option value="<?= $prog['id'] ?>" <?= (isset($item['program_id']) && $item['program_id'] == $prog['id']) ? 'selected' : '' ?>><?= $prog['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Satuan</label>
                                <select name="unit" class="form-select">
                                    <?php foreach($units as $key => $val): ?>
                                    <option value="<?= $key ?>" <?= (isset($item['unit']) && $item['unit'] == $key) ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Stok Saat Ini</label>
                                <input type="number" name="current_stock" class="form-control" value="<?= $item['current_stock'] ?? 0 ?>" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Stok Minimum</label>
                                <input type="number" name="minimum_stock" class="form-control" value="<?= $item['minimum_stock'] ?? 0 ?>" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Stok Maksimum</label>
                                <input type="number" name="maximum_stock" class="form-control" value="<?= $item['maximum_stock'] ?? 0 ?>" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Beli</label>
                                <input type="number" name="purchase_price" class="form-control" step="0.01" value="<?= $item['purchase_price'] ?? 0 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="number" name="selling_price" class="form-control" step="0.01" value="<?= $item['selling_price'] ?? 0 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" <?= (isset($item['status']) && $item['status'] == 'active') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="inactive" <?= (isset($item['status']) && $item['status'] == 'inactive') ? 'selected' : '' ?>>Tidak Aktif</option>
                                    <option value="discontinued" <?= (isset($item['status']) && $item['status'] == 'discontinued') ? 'selected' : '' ?>>Discontinue</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ID Supplier</label>
                                <input type="text" name="supplier_id" class="form-control" value="<?= $item['supplier_id'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Supplier</label>
                                <input type="text" name="supplier_name" class="form-control" value="<?= $item['supplier_name'] ?? '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="/inventory/items" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Update Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?= $this->endSection() ?>

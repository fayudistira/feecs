<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-geo-alt-plus me-2"></i>Tambah Lokasi Baru</h4>
            <a href="/inventory/locations" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post" action="/inventory/locations/store">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lokasi</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <select name="type" class="form-select">
                                    <option value="storage">Penyimpanan</option>
                                    <option value="warehouse">Gudang</option>
                                    <option value="room">Ruangan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_default" class="form-check-input" id="is_default">
                            <label class="form-check-label" for="is_default">Jadikan lokasi utama</label>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="/inventory/locations" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan Lokasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?= $this->endSection() ?>

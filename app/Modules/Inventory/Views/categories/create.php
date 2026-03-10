<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-folder-plus me-2"></i>Tambah Kategori Baru</h4>
            <a href="/inventory/categories" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post" action="/inventory/categories/store">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori Induk</label>
                        <select name="parent_id" class="form-select">
                            <option value="">Tanpa Induk</option>
                            <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>

                    <div class="text-end">
                        <a href="/inventory/categories" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?= $this->endSection() ?>

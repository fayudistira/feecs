<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-folder me-2"></i>Kategori Inventaris</h4>
            <a href="/inventory/categories/create" class="btn btn-primary">Tambah Kategori</a>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if(empty($categories)): ?>
                <p class="text-muted text-center py-4">Tidak ada kategori ditemukan</p>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Induk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $cat): ?>
                        <tr>
                            <td><?= $cat['name'] ?></td>
                            <td><?= $cat['description'] ?? '-' ?></td>
                            <td><?= $cat['parent_id'] ? 'Ya' : '-' ?></td>
                            <td>
                                <a href="/inventory/categories/edit/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    <?= $this->endSection() ?>

<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <h4><i class="bi bi-geo-alt me-2"></i>Lokasi Inventaris</h4>
        <a href="/inventory/locations/create" class="btn btn-primary mb-3">Tambah Lokasi</a>
        <div class="card">
            <div class="card-body">
                <?php if(empty($locations)): ?>
                <p class="text-muted">Tidak ada lokasi ditemukan</p>
                <?php else: ?>
                <table class="table">
                    <thead><tr><th>Nama</th><th>Tipe</th><th>Alamat</th><th>Utama</th></tr></thead>
                    <tbody>
                        <?php foreach($locations as $loc): ?>
                        <tr>
                            <td><?= $loc['name'] ?></td>
                            <td><?= ucfirst($loc['type']) ?></td>
                            <td><?= $loc['address'] ?? '-' ?></td>
                            <td><?= $loc['is_default'] ? 'Ya' : '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    <?= $this->endSection() ?>

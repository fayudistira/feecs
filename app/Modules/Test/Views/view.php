<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('extra_head') ?>
<style>
    .detail-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .detail-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    .detail-value {
        font-weight: 500;
        color: #212529;
    }
    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-badge.pending { background: #fff3cd; color: #856404; }
    .status-badge.contacted { background: #d1ecf1; color: #0c5460; }
    .status-badge.confirmed { background: #d4edda; color: #155724; }
    .status-badge.cancelled { background: #f8d7da; color: #721c24; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('test/hsk-registrations') ?>">HSK Registrations</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
            <h4 class="mb-1"><?= $title ?></h4>
            <p class="text-muted mb-0">Informasi lengkap pendaftaran simulasi HSK</p>
        </div>
        <div>
            <a href="<?= base_url('test/hsk-registrations') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            <?php if (auth()->user()->can('test.manage')): ?>
            <button type="button" class="btn btn-dark-red" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                <i class="bi bi-pencil me-1"></i>Ubah Status
            </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Info -->
        <div class="col-lg-8">
            <div class="card detail-card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2 text-dark-red"></i>
                        Informasi Pendaftaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-label">Nama Lengkap</div>
                            <div class="detail-value"><?= esc($registration['full_name']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">
                                <a href="mailto:<?= esc($registration['email']) ?>"><?= esc($registration['email']) ?></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Nomor WhatsApp</div>
                            <div class="detail-value">
                                <a href="https://wa.me/<?= esc(str_replace([' ', '-', '+'], '', $registration['phone'])) ?>" target="_blank">
                                    <?= esc($registration['phone']) ?> <i class="bi bi-whatsapp text-success"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Tanggal Lahir</div>
                            <div class="detail-value">
                                <?= $registration['birth_date'] ? date('d F Y', strtotime($registration['birth_date'])) : '-' ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value"><?= esc($registration['address'] ?? '-') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card detail-card mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-mortarboard me-2 text-dark-red"></i>
                        Latar Belakang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-label">Pendidikan Terakhir</div>
                            <div class="detail-value"><?= esc($registration['education'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Pekerjaan</div>
                            <div class="detail-value"><?= esc($registration['occupation'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Tingkat Mandarin Saat Ini</div>
                            <div class="detail-value">
                                <?php if ($registration['mandarin_level']): ?>
                                <span class="badge bg-danger"><?= esc($registration['mandarin_level']) ?></span>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-label">Catatan Tambahan</div>
                            <div class="detail-value"><?= nl2br(esc($registration['notes'] ?? '-')) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card detail-card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2 text-dark-red"></i>
                        Status & Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="detail-label">Tingkat HSK</div>
                        <div class="h4 text-danger mb-0"><?= esc($registration['hsk_level']) ?></div>
                    </div>
                    <div class="mb-4">
                        <div class="detail-label">Status</div>
                        <span class="status-badge <?= $registration['status'] ?>">
                            <?= ucfirst($registration['status']) ?>
                        </span>
                    </div>
                    <div class="mb-4">
                        <div class="detail-label">Tanggal Pendaftaran</div>
                        <div class="detail-value">
                            <?= date('d F Y', strtotime($registration['created_at'])) ?>
                            <small class="text-muted d-block"><?= date('H:i:s', strtotime($registration['created_at'])) ?></small>
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Terakhir Diperbarui</div>
                        <div class="detail-value">
                            <?= date('d F Y', strtotime($registration['updated_at'])) ?>
                            <small class="text-muted d-block"><?= date('H:i:s', strtotime($registration['updated_at'])) ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (auth()->user()->can('test.delete')): ?>
            <div class="card detail-card mt-4 border-danger">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">Hapus permanen data registrasi ini.</p>
                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Hapus Registrasi
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<?php if (auth()->user()->can('test.manage')): ?>
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('test/hsk-registrations/update-status/' . $registration['id']) ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?= $registration['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="contacted" <?= $registration['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                            <option value="confirmed" <?= $registration['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="cancelled" <?= $registration['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark-red">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Delete Modal -->
<?php if (auth()->user()->can('test.delete')): ?>
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Registrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus registrasi dari <strong><?= esc($registration['full_name']) ?></strong>?</p>
                <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="post" action="<?= base_url('test/hsk-registrations/delete/' . $registration['id']) ?>">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

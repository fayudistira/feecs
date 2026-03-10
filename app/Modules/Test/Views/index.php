<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('extra_head') ?>
<style>
    .stat-card {
        border-radius: 12px;
        padding: 1.5rem;
        color: white;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .stat-card.pending { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); }
    .stat-card.contacted { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }
    .stat-card.confirmed { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
    .stat-card.cancelled { background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); }
    .stat-card.total { background: linear-gradient(135deg, #8B0000 0%, #B22222 100%); }
    
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
    
    .table-action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><?= $title ?></h4>
            <p class="text-muted mb-0">Kelola pendaftaran simulasi HSK</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card total">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Total</div>
                        <div class="h3 mb-0"><?= $stats['total'] ?></div>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card pending">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Pending</div>
                        <div class="h3 mb-0"><?= $stats['pending'] ?></div>
                    </div>
                    <i class="bi bi-clock fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card contacted">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Contacted</div>
                        <div class="h3 mb-0"><?= $stats['contacted'] ?></div>
                    </div>
                    <i class="bi bi-chat-dots fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card confirmed">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small opacity-75">Confirmed</div>
                        <div class="h3 mb-0"><?= $stats['confirmed'] ?></div>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, email, atau phone..." value="<?= $filters['search'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="contacted" <?= ($filters['status'] ?? '') === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                        <option value="confirmed" <?= ($filters['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Level HSK</label>
                    <select name="level" class="form-select">
                        <option value="">Semua Level</option>
                        <?php foreach ($levelOptions as $level): ?>
                        <option value="<?= $level ?>" <?= ($filters['level'] ?? '') === $level ? 'selected' : '' ?>><?= $level ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark-red w-100">
                        <i class="bi bi-filter me-1"></i>Filter
                    </button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="<?= base_url('test/hsk-registrations') ?>" class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Registrations Table -->
    <div class="card">
        <div class="card-body">
            <?php if (session()->getFlashData('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashData('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashData('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashData('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>HSK Level</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($registrations)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data registrasi
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($registrations as $index => $reg): ?>
                        <tr>
                            <td><?= ($page - 1) * $perPage + $index + 1 ?></td>
                            <td>
                                <div class="fw-semibold"><?= esc($reg['full_name']) ?></div>
                                <?php if ($reg['occupation']): ?>
                                <small class="text-muted"><?= esc($reg['occupation']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($reg['email']) ?></td>
                            <td><?= esc($reg['phone']) ?></td>
                            <td>
                                <span class="badge bg-danger"><?= esc($reg['hsk_level']) ?></span>
                            </td>
                            <td>
                                <span class="status-badge <?= $reg['status'] ?>">
                                    <?= ucfirst($reg['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?= date('d M Y', strtotime($reg['created_at'])) ?>
                                <small class="text-muted d-block"><?= date('H:i', strtotime($reg['created_at'])) ?></small>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('test/hsk-registrations/view/' . $reg['id']) ?>" 
                                       class="btn btn-sm btn-outline-dark-red table-action-btn" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if (auth()->user()->can('test.manage')): ?>
                                    <button type="button" class="btn btn-sm btn-outline-secondary table-action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusModal<?= $reg['id'] ?>"
                                            title="Ubah Status">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Status Update Modal -->
                                <div class="modal fade" id="statusModal<?= $reg['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ubah Status - <?= esc($reg['full_name']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="post" action="<?= base_url('test/hsk-registrations/update-status/' . $reg['id']) ?>">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="pending" <?= $reg['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="contacted" <?= $reg['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                                                            <option value="confirmed" <?= $reg['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                            <option value="cancelled" <?= $reg['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
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
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total > $perPage): ?>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan <?= ($page - 1) * $perPage + 1 ?> - <?= min($page * $perPage, $total) ?> dari <?= $total ?> data
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?><?= $filters['status'] ? '&status=' . $filters['status'] : '' ?><?= $filters['level'] ? '&level=' . $filters['level'] : '' ?><?= $filters['search'] ? '&search=' . $filters['search'] : '' ?>">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= ceil($total / $perPage); $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= $filters['status'] ? '&status=' . $filters['status'] : '' ?><?= $filters['level'] ? '&level=' . $filters['level'] : '' ?><?= $filters['search'] ? '&search=' . $filters['search'] : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < ceil($total / $perPage)): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?><?= $filters['status'] ? '&status=' . $filters['status'] : '' ?><?= $filters['level'] ? '&level=' . $filters['level'] : '' ?><?= $filters['search'] ? '&search=' . $filters['search'] : '' ?>">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

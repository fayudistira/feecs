<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3>Programs</h3>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                <i class="bi bi-file-earmark-arrow-up"></i> Bulk Upload
            </button>
            <a href="<?= base_url('program/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Program
            </a>
        </div>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
    
    <?php if (session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show">
            <?= session()->getFlashdata('warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
    
    <!-- Search and Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="get" action="<?= base_url('program') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search programs..." value="<?= esc($keyword ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="category" class="form-control" 
                               placeholder="Category" value="<?= esc($category ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Programs Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Registration Fee</th>
                            <th>Tuition Fee</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Thumbnail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($programs)): ?>
                            <?php foreach ($programs as $program): ?>
                            <tr>
                                <td><strong><?= esc($program['title']) ?></strong></td>
                                <td><?= esc($program['category'] ?? '-') ?></td>
                                <td><?= esc($program['sub_category'] ?? '-') ?></td>
                                <td>Rp <?= number_format($program['registration_fee'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($program['tuition_fee'], 0, ',', '.') ?></td>
                                <td><?= number_format($program['discount'], 2) ?>%</td>
                                <td>
                                    <?php if ($program['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if (!empty($program['thumbnail'])): ?>
                                        <img src="<?= base_url('uploads/programs/thumbs/' . $program['thumbnail']) ?>" 
                                             alt="Thumbnail" style="width: 50px; height: 50px; object-fit: cover;" 
                                             class="rounded">
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('program/view/' . $program['id']) ?>" 
                                       class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('program/edit/' . $program['id']) ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('program/delete/' . $program['id']) ?>" 
                                       class="btn btn-sm btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this program?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No programs found.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (isset($pager)): ?>
                <div class="mt-3">
                    <?= $pager->links() ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<!-- Bulk Upload Modal -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkUploadModalLabel">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Bulk Upload Programs
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('program/bulk-upload') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Instructions:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Download the Excel template below</li>
                            <li>Fill in your program data following the format</li>
                            <li>Upload the completed file</li>
                            <li>Maximum file size: 5MB</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <a href="<?= base_url('program/download-template') ?>" class="btn btn-outline-primary w-100">
                            <i class="bi bi-download me-2"></i>Download Excel Template
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Upload Excel File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" 
                               accept=".xlsx,.xls" required>
                        <small class="text-muted">Accepted formats: .xlsx, .xls</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> Make sure all required fields are filled correctly. 
                        Rows with errors will be skipped.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

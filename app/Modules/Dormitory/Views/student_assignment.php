<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold"><i class="bi bi-person-badge me-2"></i>Student Dormitory Assignment</h2>
        <p class="text-muted">View student's dormitory assignment details</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?= base_url('dormitory/search') ?>" class="btn btn-outline-secondary me-2">
            <i class="bi bi-search me-1"></i> Search Another
        </a>
        <a href="<?= base_url('dormitory') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <!-- Student Information -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-header">
                <i class="bi bi-person me-2"></i>Student Information
            </div>
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($student['full_name'] ?? 'Student') ?>&background=8B0000&color=fff&size=100" 
                     class="rounded-circle mb-3" alt="Student Photo">
                <h5 class="fw-bold"><?= esc($student['full_name'] ?? 'N/A') ?></h5>
                <p class="text-muted mb-2">
                    <i class="bi bi-hash me-1"></i><?= esc($student['student_number'] ?? 'N/A') ?>
                </p>
                <?php if (!empty($student['phone'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-telephone me-1"></i>
                        <a href="tel:<?= esc($student['phone']) ?>"><?= esc($student['phone']) ?></a>
                    </p>
                <?php endif ?>
                <?php if (!empty($student['email'])): ?>
                    <p class="mb-0">
                        <i class="bi bi-envelope me-1"></i>
                        <a href="mailto:<?= esc($student['email']) ?>"><?= esc($student['email']) ?></a>
                    </p>
                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- Dormitory Assignment -->
    <div class="col-md-8">
        <?php if (!empty($student['room_name'])): ?>
            <div class="card dashboard-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-building me-2"></i>Current Dormitory Assignment</span>
                    <span class="badge bg-success">Assigned</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted" style="width: 120px;">Room Name</td>
                                    <td class="fw-bold"><?= esc($student['room_name']) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Location</td>
                                    <td><?= esc($student['location']) ?></td>
                                </tr>
                                <?php if (!empty($student['map_url'])): ?>
                                    <tr>
                                        <td class="text-muted">Map</td>
                                        <td>
                                            <a href="<?= esc($student['map_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-map me-1"></i> Open Map
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted" style="width: 120px;">Start Date</td>
                                    <td><?= $student['start_date'] ?? '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">End Date</td>
                                    <td><?= $student['end_date'] ?? 'Ongoing' ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status</td>
                                    <td>
                                        <span class="badge bg-success"><?= ucfirst($student['assignment_status']) ?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <?php if (!empty($student['notes'])): ?>
                        <div class="mt-3 pt-3 border-top">
                            <h6 class="text-muted">Notes</h6>
                            <p class="mb-0"><?= nl2br(esc($student['notes'])) ?></p>
                        </div>
                    <?php endif ?>
                </div>
                <div class="card-footer text-end">
                    <a href="<?= base_url('dormitory/show/' . $student['dormitory_id']) ?>" class="btn btn-primary">
                        <i class="bi bi-eye me-1"></i> View Dormitory Details
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="card dashboard-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-house-x fs-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">No Dormitory Assignment</h5>
                    <p class="text-muted">This student has not been assigned to any dormitory yet.</p>
                    <a href="<?= base_url('dormitory') ?>" class="btn btn-dark-red">
                        <i class="bi bi-building me-1"></i> Go to Dormitory Management
                    </a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold"><i class="bi bi-building me-2"></i><?= esc($dormitory['room_name']) ?></h2>
        <p class="text-muted"><?= esc($dormitory['location']) ?></p>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?= base_url('dormitory/assignments/' . $dormitory['id']) ?>" class="btn btn-success me-2">
            <i class="bi bi-people me-1"></i> Manage Assignments
        </a>
        <a href="<?= base_url('dormitory/edit/' . $dormitory['id']) ?>" class="btn btn-primary me-2">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="<?= base_url('dormitory') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<?php if (session('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?= session('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif ?>

<div class="row">
    <!-- Left Column - Gallery -->
    <div class="col-md-5">
        <div class="card dashboard-card mb-4">
            <div class="card-header">
                <i class="bi bi-images me-2"></i>Photo Gallery
            </div>
            <div class="card-body">
                <?php if (!empty($dormitory['gallery'])): ?>
                    <!-- Main Image -->
                    <div class="mb-3">
                        <img src="<?= base_url('uploads/' . $dormitory['gallery'][0]) ?>" 
                             class="img-fluid rounded w-100" id="mainImage"
                             style="max-height: 300px; object-fit: cover;">
                    </div>
                    <!-- Thumbnails -->
                    <div class="d-flex gap-2 flex-wrap">
                        <?php foreach ($dormitory['gallery'] as $photo): ?>
                            <img src="<?= base_url('uploads/' . $photo) ?>" 
                                 class="rounded thumbnail-img" 
                                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                 onclick="document.getElementById('mainImage').src='<?= base_url('uploads/' . $photo) ?>'">
                        <?php endforeach ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-image fs-1"></i>
                        <p class="mt-2">No photos available</p>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <!-- Map -->
        <?php if (!empty($dormitory['map_url'])): ?>
        <div class="card dashboard-card">
            <div class="card-header">
                <i class="bi bi-geo-alt me-2"></i>Location
            </div>
            <div class="card-body">
                <a href="<?= esc($dormitory['map_url']) ?>" target="_blank" class="btn btn-outline-primary w-100">
                    <i class="bi bi-map me-1"></i> Open in Google Maps
                </a>
            </div>
        </div>
        <?php endif ?>
    </div>

    <!-- Right Column - Details -->
    <div class="col-md-7">
        <!-- Status Cards -->
        <div class="row mb-4">
            <div class="col-4">
                <div class="card dashboard-card stat-card text-center">
                    <div class="card-body py-3">
                        <div class="stat-label">Capacity</div>
                        <div class="stat-number"><?= $dormitory['room_capacity'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card dashboard-card stat-card text-center">
                    <div class="card-body py-3">
                        <div class="stat-label">Occupied</div>
                        <div class="stat-number text-danger"><?= $dormitory['occupied_beds'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card dashboard-card stat-card text-center">
                    <div class="card-body py-3">
                        <div class="stat-label">Available</div>
                        <div class="stat-number text-success"><?= $dormitory['available_beds'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="card dashboard-card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Room Details
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width: 150px;">Room Name</td>
                        <td class="fw-bold"><?= esc($dormitory['room_name']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Location</td>
                        <td><?= esc($dormitory['location']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <?php if ($dormitory['status'] === 'available'): ?>
                                <span class="badge bg-success">Available</span>
                            <?php elseif ($dormitory['status'] === 'full'): ?>
                                <span class="badge bg-warning text-dark">Full</span>
                            <?php elseif ($dormitory['status'] === 'maintenance'): ?>
                                <span class="badge bg-secondary">Maintenance</span>
                            <?php else: ?>
                                <span class="badge bg-dark">Inactive</span>
                            <?php endif ?>
                        </td>
                    </tr>
                    <?php if (!empty($dormitory['note'])): ?>
                    <tr>
                        <td class="text-muted">Notes</td>
                        <td><?= nl2br(esc($dormitory['note'])) ?></td>
                    </tr>
                    <?php endif ?>
                </table>
            </div>
        </div>

        <!-- Facilities -->
        <div class="card dashboard-card mb-4">
            <div class="card-header">
                <i class="bi bi-check-circle me-2"></i>Facilities
            </div>
            <div class="card-body">
                <?php if (!empty($dormitory['facilities'])): ?>
                    <div class="row">
                        <?php foreach ($dormitory['facilities'] as $facility): ?>
                            <div class="col-md-6 mb-2">
                                <i class="bi bi-check2 text-success me-2"></i><?= esc($facility) ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No facilities listed.</p>
                <?php endif ?>
            </div>
        </div>

        <!-- Current Occupants -->
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Current Occupants</span>
                <span class="badge bg-primary"><?= count(array_filter($assignments, fn($a) => $a['status'] === 'active')) ?></span>
            </div>
            <div class="card-body p-0">
                <?php $activeAssignments = array_filter($assignments, fn($a) => $a['status'] === 'active'); ?>
                <?php if (!empty($activeAssignments)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover compact-table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Student Number</th>
                                    <th>Start Date</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activeAssignments as $assignment): ?>
                                    <tr>
                                        <td><?= esc($assignment['full_name'] ?? 'N/A') ?></td>
                                        <td><?= esc($assignment['student_number'] ?? 'N/A') ?></td>
                                        <td><?= $assignment['start_date'] ?? '-' ?></td>
                                        <td>
                                            <?php if (!empty($assignment['phone'])): ?>
                                                <a href="tel:<?= esc($assignment['phone']) ?>"><?= esc($assignment['phone']) ?></a>
                                            <?php else: ?>
                                                -
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-person-plus fs-3"></i>
                        <p class="mt-2 mb-0">No occupants assigned</p>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.thumbnail-img {
    border: 2px solid transparent;
    transition: border-color 0.2s;
}
.thumbnail-img:hover {
    border-color: var(--dark-red);
}
</style>
<?= $this->endSection() ?>

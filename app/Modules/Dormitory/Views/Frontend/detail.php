<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<?php
// Get random thumbnail
$thumbnail = !empty($dormitory['gallery']) ? $dormitory['gallery'][array_rand($dormitory['gallery'])] : null;
?>
<!-- Breadcrumb -->
<div class="bg-light py-2 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('dormitories') ?>">Dormitory</a></li>
                <li class="breadcrumb-item active"><?= esc($dormitory['room_name']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Left Column - Gallery -->
        <div class="col-lg-6">
            <!-- Main Image -->
            <div class="card border-0 shadow-sm mb-3 overflow-hidden">
                <?php if (!empty($dormitory['gallery'])): ?>
                    <img src="<?= base_url('uploads/' . $dormitory['gallery'][0]) ?>" 
                         class="card-img-top" id="mainImage"
                         style="width: 100%; height: 400px; object-fit: cover;"
                         alt="<?= esc($dormitory['room_name']) ?>">
                <?php else: ?>
                    <div class="w-100 d-flex align-items-center justify-content-center bg-light" style="height: 400px;">
                        <i class="bi bi-building fs-1 text-muted"></i>
                    </div>
                <?php endif ?>
            </div>
            
            <!-- Thumbnails -->
            <?php if (count($dormitory['gallery'] ?? []) > 1): ?>
                <div class="d-flex gap-2 overflow-auto pb-2">
                    <?php foreach ($dormitory['gallery'] as $photo): ?>
                        <img src="<?= base_url('uploads/' . $photo) ?>" 
                             class="rounded thumbnail-img flex-shrink-0" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="document.getElementById('mainImage').src='<?= base_url('uploads/' . $photo) ?>'">
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            
            <!-- Map -->
            <?php if (!empty($dormitory['map_url'])): ?>
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="bi bi-geo-alt me-2"></i>Location</h6>
                        <a href="<?= esc($dormitory['map_url']) ?>" target="_blank" class="btn btn-outline-primary w-100">
                            <i class="bi bi-map me-1"></i> Open in Google Maps
                        </a>
                    </div>
                </div>
            <?php endif ?>
        </div>
        
        <!-- Right Column - Details -->
        <div class="col-lg-6">
            <!-- Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-start">
                    <h1 class="fw-bold h2 mb-2"><?= esc($dormitory['room_name']) ?></h1>
                    <?php if ($dormitory['status'] === 'available' && $dormitory['available_beds'] > 0): ?>
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-check-circle me-1"></i>Available
                        </span>
                    <?php elseif ($dormitory['status'] === 'full'): ?>
                        <span class="badge bg-warning text-dark fs-6">Full</span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">Maintenance</span>
                    <?php endif ?>
                </div>
                <p class="text-muted mb-0">
                    <i class="bi bi-geo-alt me-1"></i><?= esc($dormitory['location']) ?>
                </p>
            </div>
            
            <!-- Availability Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-3">Availability</h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="display-6 fw-bold" style="color: var(--dark-red);"><?= $dormitory['room_capacity'] ?></div>
                            <small class="text-muted">Total Beds</small>
                        </div>
                        <div class="col-4">
                            <div class="display-6 fw-bold text-danger"><?= $dormitory['occupied_beds'] ?></div>
                            <small class="text-muted">Occupied</small>
                        </div>
                        <div class="col-4">
                            <div class="display-6 fw-bold text-success"><?= $dormitory['available_beds'] ?></div>
                            <small class="text-muted">Available</small>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="progress mt-3" style="height: 10px;">
                        <?php $percentage = ($dormitory['occupied_beds'] / $dormitory['room_capacity']) * 100; ?>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $percentage ?>%">
                        </div>
                    </div>
                    <small class="text-muted"><?= round($percentage) ?>% occupied</small>
                </div>
            </div>
            
            <!-- Facilities -->
            <?php if (!empty($dormitory['facilities'])): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-3">Facilities</h6>
                        <div class="row">
                            <?php foreach ($dormitory['facilities'] as $facility): ?>
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span><?= esc($facility) ?></span>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            
            <!-- Notes -->
            <?php if (!empty($dormitory['note'])): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-3">Additional Information</h6>
                        <p class="mb-0"><?= nl2br(esc($dormitory['note'])) ?></p>
                    </div>
                </div>
            <?php endif ?>
            
            <!-- CTA -->
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, var(--dark-red) 0%, var(--medium-red) 100%);">
                <div class="card-body text-white text-center py-4">
                    <h5 class="mb-3">Interested in this dormitory?</h5>
                    <p class="mb-3 opacity-75">Contact us for more information or to reserve a bed.</p>
                    <a href="<?= base_url('contact') ?>" class="btn btn-light">
                        <i class="bi bi-envelope me-1"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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

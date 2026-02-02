<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<div class="container py-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('programs') ?>">Programs</a></li>
            <li class="breadcrumb-item active"><?= esc($program['title']) ?></li>
        </ol>
    </nav>
</div>

<!-- Program Detail -->
<div class="container py-4">
    <div class="row">
        <!-- Program Image and Info -->
        <div class="col-lg-5 mb-4">
            <div class="card-custom">
                <?php if (!empty($program['thumbnail'])): ?>
                    <img src="<?= base_url('uploads/programs/thumbs/' . $program['thumbnail']) ?>" 
                         alt="<?= esc($program['title']) ?>" 
                         class="img-fluid rounded"
                         style="width: 100%; height: auto; max-height: 400px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                         style="height: 400px;">
                        <i class="bi bi-mortarboard" style="font-size: 5rem; color: #ccc;"></i>
                    </div>
                <?php endif ?>
            </div>
            
            <!-- Quick Info Card -->
            <div class="card-custom mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Program Information</h6>
                    
                    <?php if (!empty($program['category'])): ?>
                        <div class="mb-2">
                            <small class="text-muted">Category</small>
                            <div class="fw-bold"><?= esc($program['category']) ?></div>
                        </div>
                    <?php endif ?>
                    
                    <?php if (!empty($program['sub_category'])): ?>
                        <div class="mb-2">
                            <small class="text-muted">Sub Category</small>
                            <div class="fw-bold"><?= esc($program['sub_category']) ?></div>
                        </div>
                    <?php endif ?>
                    
                    <hr>
                    
                    <div class="mb-2">
                        <small class="text-muted">Registration Fee</small>
                        <div class="fw-bold">Rp <?= number_format($program['registration_fee'], 0, ',', '.') ?></div>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Tuition Fee</small>
                        <?php if ($program['discount'] > 0): ?>
                            <div>
                                <span class="text-decoration-line-through text-muted">
                                    Rp <?= number_format($program['tuition_fee'], 0, ',', '.') ?>
                                </span>
                                <span class="badge bg-success ms-2"><?= number_format($program['discount'], 0) ?>% OFF</span>
                            </div>
                            <div class="h5 text-dark-red fw-bold mb-0">
                                Rp <?= number_format($finalPrice, 0, ',', '.') ?>
                            </div>
                        <?php else: ?>
                            <div class="h5 text-dark-red fw-bold mb-0">
                                Rp <?= number_format($program['tuition_fee'], 0, ',', '.') ?>
                            </div>
                        <?php endif ?>
                        <small class="text-muted">per semester</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Program Details -->
        <div class="col-lg-7">
            <div class="mb-4">
                <h1 class="fw-bold mb-2"><?= esc($program['title']) ?></h1>
                <?php if (!empty($program['category'])): ?>
                    <span class="badge bg-dark-red"><?= esc($program['category']) ?></span>
                <?php endif ?>
            </div>
            
            <!-- Description -->
            <?php if (!empty($program['description'])): ?>
                <div class="card-custom mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="bi bi-file-text me-2"></i>Description</h5>
                        <p class="text-muted"><?= nl2br(esc($program['description'])) ?></p>
                    </div>
                </div>
            <?php endif ?>
            
            <!-- Features -->
            <?php if (!empty($program['features']) && is_array($program['features'])): ?>
                <div class="card-custom mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="bi bi-star me-2"></i>Program Features</h5>
                        <ul class="list-unstyled">
                            <?php foreach ($program['features'] as $feature): ?>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <?= esc($feature) ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
            
            <!-- Facilities -->
            <?php if (!empty($program['facilities']) && is_array($program['facilities'])): ?>
                <div class="card-custom mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="bi bi-building me-2"></i>Facilities</h5>
                        <ul class="list-unstyled">
                            <?php foreach ($program['facilities'] as $facility): ?>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                    <?= esc($facility) ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
            
            <!-- Extra Facilities -->
            <?php if (!empty($program['extra_facilities']) && is_array($program['extra_facilities'])): ?>
                <div class="card-custom mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Extra Facilities</h5>
                        <ul class="list-unstyled">
                            <?php foreach ($program['extra_facilities'] as $extra): ?>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                    <?= esc($extra) ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
            
            <!-- Action Buttons -->
            <div class="card-custom">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ready to Join?</h5>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('apply/' . $program['id']) ?>" 
                           class="btn btn-dark-red btn-lg">
                            <i class="bi bi-pencil-square me-2"></i>Apply for This Program
                        </a>
                        <a href="https://wa.me/<?= config('App')->adminWhatsApp ?? '6281234567890' ?>?text=<?= urlencode("Hello, I'm interested in the " . $program['title'] . " program. Can you provide more information?") ?>" 
                           target="_blank"
                           class="btn btn-success btn-lg">
                            <i class="bi bi-whatsapp me-2"></i>Ask Admin via WhatsApp
                        </a>
                        <a href="<?= base_url('programs') ?>" 
                           class="btn btn-outline-dark-red">
                            <i class="bi bi-arrow-left me-2"></i>Back to Programs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
}

.breadcrumb-item a {
    color: var(--dark-red);
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #6c757d;
}
</style>

<?= $this->endSection() ?>

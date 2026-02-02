<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="hero-section py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Our Programs</h1>
        <p class="lead">Explore our comprehensive range of educational programs designed to help you achieve your goals</p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
    
    <?php if (empty($programs)): ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            <h3 class="mt-3">No Programs Available</h3>
            <p class="text-muted">Please check back later for available programs.</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($programs as $program): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card-custom h-100 program-card">
                        <!-- Program Image -->
                        <div class="program-image">
                            <?php if (!empty($program['thumbnail'])): ?>
                                <img src="<?= base_url('uploads/programs/thumbs/' . $program['thumbnail']) ?>" 
                                     alt="<?= esc($program['title']) ?>" 
                                     class="card-img-top"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="bi bi-mortarboard" style="font-size: 3rem; color: #ccc;"></i>
                                </div>
                            <?php endif ?>
                            
                            <!-- Category Badge -->
                            <?php if (!empty($program['category'])): ?>
                                <span class="badge bg-dark-red position-absolute top-0 end-0 m-2">
                                    <?= esc($program['category']) ?>
                                </span>
                            <?php endif ?>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Program Title -->
                            <h5 class="card-title fw-bold"><?= esc($program['title']) ?></h5>
                            
                            <!-- Program Description -->
                            <p class="card-text text-muted flex-grow-1">
                                <?php 
                                $description = $program['description'] ?? 'No description available';
                                echo esc(strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description);
                                ?>
                            </p>
                            
                            <!-- Pricing -->
                            <div class="pricing-section mb-3">
                                <?php if ($program['discount'] > 0): ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-decoration-line-through text-muted">
                                            Rp <?= number_format($program['tuition_fee'], 0, ',', '.') ?>
                                        </span>
                                        <span class="badge bg-success"><?= number_format($program['discount'], 0) ?>% OFF</span>
                                    </div>
                                    <div class="h5 text-dark-red fw-bold mb-0">
                                        Rp <?= number_format($program['tuition_fee'] * (1 - $program['discount'] / 100), 0, ',', '.') ?>
                                    </div>
                                <?php else: ?>
                                    <div class="h5 text-dark-red fw-bold mb-0">
                                        Rp <?= number_format($program['tuition_fee'], 0, ',', '.') ?>
                                    </div>
                                <?php endif ?>
                                <small class="text-muted">per semester</small>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('programs/' . $program['id']) ?>" 
                                   class="btn btn-outline-dark-red">
                                    <i class="bi bi-info-circle me-1"></i> View Details
                                </a>
                                <a href="<?= base_url('apply/' . $program['id']) ?>" 
                                   class="btn btn-dark-red">
                                    <i class="bi bi-pencil-square me-1"></i> Apply Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<style>
.program-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.program-image {
    position: relative;
    overflow: hidden;
}

.program-image img {
    transition: transform 0.3s ease;
}

.program-card:hover .program-image img {
    transform: scale(1.05);
}

.pricing-section {
    border-top: 1px solid #eee;
    padding-top: 1rem;
}
</style>

<?= $this->endSection() ?>

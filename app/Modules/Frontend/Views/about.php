<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="hero-section py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">About Us</h1>
        <p class="lead">Learn more about our institution and what makes us unique</p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card-custom card mb-4">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-bullseye me-2"></i>Our Mission</h3>
                </div>
                <div class="card-body">
                    <p class="lead">To provide quality education and empower students to achieve their full potential through innovative learning experiences and comprehensive support.</p>
                </div>
            </div>
            
            <div class="card-custom card mb-4">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-clock-history me-2"></i>Our History</h3>
                </div>
                <div class="card-body">
                    <p>Founded in 2000, our institution has been at the forefront of educational excellence for over two decades. We have grown from a small college to a comprehensive institution serving thousands of students.</p>
                    <p>Throughout our journey, we have maintained our commitment to academic excellence, innovation, and student success. Our graduates have gone on to make significant contributions in various fields across the globe.</p>
                </div>
            </div>
            
            <div class="card-custom card">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-heart me-2"></i>Our Values</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Excellence</h5>
                                    <p class="text-muted mb-0">We strive for the highest standards in everything we do.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Integrity</h5>
                                    <p class="text-muted mb-0">We maintain honesty and strong moral principles.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    <i class="bi bi-lightbulb"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Innovation</h5>
                                    <p class="text-muted mb-0">We embrace new ideas and creative solutions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Diversity</h5>
                                    <p class="text-muted mb-0">We celebrate and respect differences.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card-custom card mb-4">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i>Quick Facts</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong style="color: var(--dark-red);">Founded:</strong><br>
                            <span class="text-muted">2000</span>
                        </li>
                        <li class="mb-3">
                            <strong style="color: var(--dark-red);">Students:</strong><br>
                            <span class="text-muted">5,000+</span>
                        </li>
                        <li class="mb-3">
                            <strong style="color: var(--dark-red);">Faculty:</strong><br>
                            <span class="text-muted">300+</span>
                        </li>
                        <li class="mb-3">
                            <strong style="color: var(--dark-red);">Programs:</strong><br>
                            <span class="text-muted">50+</span>
                        </li>
                        <li>
                            <strong style="color: var(--dark-red);">Campus Size:</strong><br>
                            <span class="text-muted">50 Acres</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card-custom card">
                <div class="card-body text-center p-4">
                    <h5 class="fw-bold mb-3">Ready to Join Us?</h5>
                    <p class="text-muted mb-3">Start your application today and become part of our community.</p>
                    <a href="<?= base_url('apply') ?>" class="btn btn-dark-red w-100">
                        <i class="bi bi-pencil-square me-2"></i>Apply Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

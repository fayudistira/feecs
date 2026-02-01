<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<!-- Success Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="feature-icon mx-auto" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    
                    <h1 class="fw-bold mb-3" style="color: var(--dark-red);">Application Submitted Successfully!</h1>
                    <p class="lead text-muted mb-4">Thank you for applying to our institution. Your application has been received and is being processed.</p>
                    
                    <?php if (isset($registrationNumber)): ?>
                        <div class="alert alert-info mb-4">
                            <h5 class="mb-2"><i class="bi bi-info-circle me-2"></i>Your Registration Number</h5>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-red);"><?= esc($registrationNumber) ?></h3>
                            <p class="mb-0 mt-2"><small>Please save this number for future reference</small></p>
                        </div>
                    <?php endif ?>
                    
                    <div class="card-custom card mb-4">
                        <div class="card-body text-start">
                            <h5 class="fw-bold mb-3" style="color: var(--dark-red);"><i class="bi bi-list-check me-2"></i>What Happens Next?</h5>
                            <ol class="mb-0">
                                <li class="mb-2">Our admissions team will review your application within 3-5 business days.</li>
                                <li class="mb-2">You will receive an email notification regarding the status of your application.</li>
                                <li class="mb-2">If approved, you will receive further instructions for enrollment.</li>
                                <li>For any questions, please contact our admissions office.</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="<?= base_url('/') ?>" class="btn btn-dark-red btn-lg w-100">
                                <i class="bi bi-house me-2"></i>Back to Home
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('contact') ?>" class="btn btn-outline-dark-red btn-lg w-100">
                                <i class="bi bi-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Need help? Contact us at <a href="mailto:admissions@erpsystem.edu" style="color: var(--dark-red);">admissions@erpsystem.edu</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

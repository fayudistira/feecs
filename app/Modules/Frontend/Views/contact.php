<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="hero-section py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
        <p class="lead">Get in touch with us for any inquiries or assistance</p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card-custom card">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-envelope me-2"></i>Send Us a Message</h3>
                </div>
                <div class="card-body">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i><?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif ?>
                    
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif ?>
                    
                    <form action="<?= base_url('contact/submit') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" value="<?= old('subject') ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="6" required><?= old('message') ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark-red btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card-custom card mb-4">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Our Location</h4>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <strong>Address:</strong><br>
                        123 Education Street<br>
                        City, Province 12345<br>
                        Indonesia
                    </p>
                    <p class="mb-3">
                        <strong>Phone:</strong><br>
                        <a href="tel:+621234567890" style="color: var(--dark-red);">+62 123 4567 890</a>
                    </p>
                    <p class="mb-0">
                        <strong>Email:</strong><br>
                        <a href="mailto:info@erpsystem.edu" style="color: var(--dark-red);">info@erpsystem.edu</a>
                    </p>
                </div>
            </div>
            
            <div class="card-custom card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-clock me-2"></i>Office Hours</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong>Monday - Friday:</strong><br>
                            <span class="text-muted">8:00 AM - 5:00 PM</span>
                        </li>
                        <li class="mb-2">
                            <strong>Saturday:</strong><br>
                            <span class="text-muted">9:00 AM - 1:00 PM</span>
                        </li>
                        <li>
                            <strong>Sunday:</strong><br>
                            <span class="text-muted">Closed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

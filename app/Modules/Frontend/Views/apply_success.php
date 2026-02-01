<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle text-success" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    
                    <h1 class="text-success mb-3">Application Submitted Successfully!</h1>
                    
                    <?php if (session('success')): ?>
                        <div class="alert alert-success">
                            <?= session('success') ?>
                        </div>
                    <?php endif ?>
                    
                    <?php if (session('registration_number')): ?>
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h4>Your Registration Number</h4>
                                <h2 class="text-primary fw-bold"><?= esc(session('registration_number')) ?></h2>
                                <p class="text-muted mb-0">Please save this number for future reference</p>
                            </div>
                        </div>
                    <?php endif ?>
                    
                    <p class="lead">Thank you for applying to our institution. We have received your application and will review it shortly.</p>
                    <p>You will receive an email confirmation at the address you provided. Our admissions team will contact you regarding the next steps in the admission process.</p>
                    
                    <div class="mt-4">
                        <a href="<?= base_url('/') ?>" class="btn btn-primary">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

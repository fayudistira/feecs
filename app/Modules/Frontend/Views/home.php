<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Welcome to Our Institution</h1>
                <p class="lead">Start your journey with us today. Apply for admission and join our community of learners.</p>
                <a href="<?= base_url('apply') ?>" class="btn btn-primary btn-lg">Apply for Admission</a>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/500x400" alt="Campus" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3>Quality Education</h3>
                    <p>We provide world-class education with experienced faculty and modern facilities.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3>Career Support</h3>
                    <p>Our career services help students achieve their professional goals.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3>Global Network</h3>
                    <p>Join our alumni network spanning across the globe.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

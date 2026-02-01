<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4">About Us</h1>
    
    <div class="row">
        <div class="col-lg-8">
            <h2>Our Mission</h2>
            <p class="lead">To provide quality education and empower students to achieve their full potential.</p>
            
            <h3 class="mt-4">Our History</h3>
            <p>Founded in 2000, our institution has been at the forefront of educational excellence for over two decades. We have grown from a small college to a comprehensive institution serving thousands of students.</p>
            
            <h3 class="mt-4">Our Values</h3>
            <ul>
                <li><strong>Excellence:</strong> We strive for the highest standards in everything we do.</li>
                <li><strong>Integrity:</strong> We maintain honesty and strong moral principles.</li>
                <li><strong>Innovation:</strong> We embrace new ideas and creative solutions.</li>
                <li><strong>Diversity:</strong> We celebrate and respect differences.</li>
            </ul>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Quick Facts</h4>
                    <ul class="list-unstyled">
                        <li><strong>Founded:</strong> 2000</li>
                        <li><strong>Students:</strong> 5,000+</li>
                        <li><strong>Faculty:</strong> 300+</li>
                        <li><strong>Programs:</strong> 50+</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

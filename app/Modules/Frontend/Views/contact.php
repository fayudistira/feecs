<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4">Contact Us</h1>
    
    <div class="row">
        <div class="col-lg-6">
            <h3>Get in Touch</h3>
            <p>Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            
            <div class="mt-4">
                <h4>Contact Information</h4>
                <p>
                    <strong>Address:</strong><br>
                    123 Education Street<br>
                    City, State 12345
                </p>
                <p>
                    <strong>Phone:</strong> +1 (555) 123-4567<br>
                    <strong>Email:</strong> info@institution.edu
                </p>
                <p>
                    <strong>Office Hours:</strong><br>
                    Monday - Friday: 8:00 AM - 5:00 PM<br>
                    Saturday: 9:00 AM - 1:00 PM<br>
                    Sunday: Closed
                </p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4>Send us a Message</h4>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

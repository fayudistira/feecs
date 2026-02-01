<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <h1 class="mb-4">Apply for Admission</h1>
    
    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif ?>
    
    <form action="<?= base_url('apply/submit') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Personal Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nickname" class="form-label">Nickname</label>
                        <input type="text" class="form-control" id="nickname" name="nickname" value="<?= old('nickname') ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?= old('gender') === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= old('gender') === 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth') ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="place_of_birth" class="form-label">Place of Birth <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="<?= old('place_of_birth') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="religion" class="form-label">Religion <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="religion" name="religion" value="<?= old('religion') ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="citizen_id" class="form-label">Citizen ID Number</label>
                        <input type="text" class="form-control" id="citizen_id" name="citizen_id" value="<?= old('citizen_id') ?>">
                        <small class="text-muted">Only if you have an ID card</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Contact Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Address -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Address</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="street_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="street_address" name="street_address" rows="2" required><?= old('street_address') ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="district" class="form-label">District/Sub-district <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="district" name="district" value="<?= old('district') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="regency" class="form-label">Regency/City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="regency" name="regency" value="<?= old('regency') ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="province" name="province" value="<?= old('province') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?= old('postal_code') ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Emergency Contact -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Emergency Contact</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="emergency_contact_name" class="form-label">Contact Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="<?= old('emergency_contact_name') ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="emergency_contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" value="<?= old('emergency_contact_phone') ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="emergency_contact_relation" class="form-label">Relationship <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="emergency_contact_relation" name="emergency_contact_relation" value="<?= old('emergency_contact_relation') ?>" required>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Family Information -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Family Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="father_name" class="form-label">Father's Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?= old('father_name') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="mother_name" class="form-label">Mother's Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?= old('mother_name') ?>" required>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Course Selection -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Course Selection</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="course" class="form-label">Desired Course/Program <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="course" name="course" value="<?= old('course') ?>" required>
                </div>
            </div>
        </div>
        
        <!-- File Uploads -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">File Uploads</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="photo" class="form-label">Profile Photo <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/jpeg,image/jpg,image/png" required>
                    <small class="text-muted">Accepted formats: JPG, JPEG, PNG. Max size: 2MB</small>
                </div>
                
                <div class="mb-3">
                    <label for="documents" class="form-label">Supporting Documents</label>
                    <input type="file" class="form-control" id="documents" name="documents[]" accept=".pdf,.doc,.docx" multiple>
                    <small class="text-muted">Accepted formats: PDF, DOC, DOCX. Max size per file: 5MB. Max 3 files</small>
                </div>
            </div>
        </div>
        
        <!-- Additional Notes -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Additional Information</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="4"><?= old('notes') ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
            <a href="<?= base_url('/') ?>" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

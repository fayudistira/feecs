<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3>Create New Program</h3>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= base_url('program') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
    
    <form action="<?= base_url('program/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Program Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" 
                               value="<?= old('title') ?>" required>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= old('description') ?></textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Thumbnail Image</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        <small class="text-muted">Recommended size: 800x600px. Max 2MB.</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" 
                               value="<?= old('category') ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sub Category</label>
                        <input type="text" name="sub_category" class="form-control" 
                               value="<?= old('sub_category') ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Delivery Mode <span class="text-danger">*</span></label>
                        <select name="mode" class="form-select" required>
                            <option value="offline" <?= old('mode', 'offline') === 'offline' ? 'selected' : '' ?>>
                                <i class="bi bi-building"></i> Offline (In-Person)
                            </option>
                            <option value="online" <?= old('mode') === 'online' ? 'selected' : '' ?>>
                                <i class="bi bi-laptop"></i> Online (Remote)
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Curriculum</h5>
            </div>
            <div class="card-body">
                <div id="curriculum-container">
                    <div class="curriculum-item mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label">Chapter Title</label>
                                <input type="text" name="curriculum[0][chapter]" class="form-control" 
                                       placeholder="e.g., Chapter 1: Introduction">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <input type="text" name="curriculum[0][description]" class="form-control" 
                                       placeholder="Brief description of this chapter">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-curriculum" disabled>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-sm" id="add-curriculum">
                    <i class="bi bi-plus-circle"></i> Add Chapter
                </button>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Fee Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Registration Fee (Rp)</label>
                        <input type="number" name="registration_fee" class="form-control" 
                               value="<?= old('registration_fee', 0) ?>" step="0.01" min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tuition Fee (Rp)</label>
                        <input type="number" name="tuition_fee" class="form-control" 
                               value="<?= old('tuition_fee', 0) ?>" step="0.01" min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount" class="form-control" 
                               value="<?= old('discount', 0) ?>" step="0.01" min="0" max="100">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Features & Facilities</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Features</label>
                        <small class="text-muted d-block mb-2">Enter one feature per line</small>
                        <textarea name="features" class="form-control" rows="6" 
                                  placeholder="e.g.&#10;Interactive Learning&#10;Expert Instructors&#10;Flexible Schedule"><?= old('features') ?></textarea>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Facilities</label>
                        <small class="text-muted d-block mb-2">Enter one facility per line</small>
                        <textarea name="facilities" class="form-control" rows="6" 
                                  placeholder="e.g.&#10;Modern Classrooms&#10;Computer Lab&#10;Library"><?= old('facilities') ?></textarea>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Extra Facilities</label>
                        <small class="text-muted d-block mb-2">Enter one extra facility per line</small>
                        <textarea name="extra_facilities" class="form-control" rows="6" 
                                  placeholder="e.g.&#10;Free WiFi&#10;Parking Area&#10;Cafeteria"><?= old('extra_facilities') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Create Program
                </button>
                <a href="<?= base_url('program') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let curriculumIndex = 1;
    const container = document.getElementById('curriculum-container');
    const addButton = document.getElementById('add-curriculum');
    
    addButton.addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'curriculum-item mb-3';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Chapter Title</label>
                    <input type="text" name="curriculum[${curriculumIndex}][chapter]" class="form-control" 
                           placeholder="e.g., Chapter ${curriculumIndex + 1}: Topic Name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <input type="text" name="curriculum[${curriculumIndex}][description]" class="form-control" 
                           placeholder="Brief description of this chapter">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-curriculum">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        container.appendChild(newItem);
        curriculumIndex++;
        
        // Enable remove buttons
        updateRemoveButtons();
    });
    
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-curriculum')) {
            e.target.closest('.curriculum-item').remove();
            updateRemoveButtons();
        }
    });
    
    function updateRemoveButtons() {
        const items = container.querySelectorAll('.curriculum-item');
        items.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-curriculum');
            if (items.length === 1) {
                removeBtn.disabled = true;
            } else {
                removeBtn.disabled = false;
            }
        });
    }
});
</script>
<?= $this->endSection() ?>

<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold"><i class="bi bi-pencil me-2"></i>Edit Dormitory</h2>
        <p class="text-muted">Update dormitory room information</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?= base_url('dormitory/show/' . $dormitory['id']) ?>" class="btn btn-outline-info me-2">
            <i class="bi bi-eye me-1"></i> View Details
        </a>
        <a href="<?= base_url('dormitory') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<?php if (session('errors')): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?>

<div class="card dashboard-card">
    <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <!-- Basic Information -->
                <div class="col-md-6">
                    <h6 class="text-muted text-uppercase mb-3">Basic Information</h6>
                    
                    <div class="mb-3">
                        <label for="room_name" class="form-label">Room Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="room_name" name="room_name" 
                               value="<?= old('room_name', $dormitory['room_name']) ?>" required
                               placeholder="e.g., Kirana A17 Sekat">
                        <small class="text-muted">Identifier for the room</small>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="location" name="location" rows="2" required><?= old('location', $dormitory['location']) ?></textarea>
                        <small class="text-muted">Full address of the dormitory</small>
                    </div>

                    <div class="mb-3">
                        <label for="map_url" class="form-label">Map URL</label>
                        <input type="url" class="form-control" id="map_url" name="map_url" 
                               value="<?= old('map_url', $dormitory['map_url'] ?? '') ?>">
                        <small class="text-muted">Google Maps or similar map link</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="room_capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="room_capacity" name="room_capacity" 
                                       value="<?= old('room_capacity', $dormitory['room_capacity']) ?>" min="1" required>
                                <small class="text-muted">Number of beds</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="available" <?= $dormitory['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                                    <option value="full" <?= $dormitory['status'] === 'full' ? 'selected' : '' ?>>Full</option>
                                    <option value="maintenance" <?= $dormitory['status'] === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                    <option value="inactive" <?= $dormitory['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities & Gallery -->
                <div class="col-md-6">
                    <h6 class="text-muted text-uppercase mb-3">Facilities & Gallery</h6>
                    
                    <div class="mb-3">
                        <label for="facilities" class="form-label">Facilities</label>
                        <textarea class="form-control" id="facilities" name="facilities" rows="4"><?= old('facilities', is_array($dormitory['facilities']) ? implode("\n", $dormitory['facilities']) : $dormitory['facilities']) ?></textarea>
                        <small class="text-muted">Enter one facility per line</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Gallery</label>
                        <?php if (!empty($dormitory['gallery'])): ?>
                            <div class="row g-2 mb-2">
                                <?php foreach ($dormitory['gallery'] as $idx => $photo): ?>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <img src="<?= base_url('uploads/' . $photo) ?>" 
                                                 class="img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                                            <div class="form-check position-absolute top-0 end-0 m-1">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="remove_images[]" value="<?= esc($photo) ?>" id="remove_<?= $idx ?>">
                                                <label class="form-check-label" for="remove_<?= $idx ?>">
                                                    <i class="bi bi-x-circle text-danger"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <small class="text-muted">Check the X to remove images</small>
                        <?php else: ?>
                            <p class="text-muted small">No photos uploaded yet.</p>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <label for="gallery" class="form-label">Add More Photos</label>
                        <input type="file" class="form-control" id="gallery" name="gallery[]" 
                               multiple accept="image/jpeg,image/jpg,image/png,image/webp">
                        <small class="text-muted">Upload multiple images (JPG, PNG, WebP). Max 5MB each.</small>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Notes</label>
                        <textarea class="form-control" id="note" name="note" rows="3"><?= old('note', $dormitory['note'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="<?= base_url('dormitory') ?>" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-dark-red">
                <i class="bi bi-check-lg me-1"></i> Update Dormitory
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

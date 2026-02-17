<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold"><i class="bi bi-search me-2"></i>Search Student Dormitory</h2>
        <p class="text-muted">Find student's dormitory assignment by name or student number</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?= base_url('dormitory') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Dormitory List
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card dashboard-card mb-4">
    <div class="card-body">
        <form action="<?= base_url('dormitory/search') ?>" method="get">
            <div class="row align-items-end">
                <div class="col-md-8">
                    <label for="q" class="form-label">Search Student</label>
                    <input type="text" class="form-control" id="q" name="q" 
                           value="<?= esc($search) ?>" 
                           placeholder="Enter student name or student number...">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark-red w-100">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Search Results -->
<?php if (!empty($search)): ?>
    <div class="card dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Search Results for "<?= esc($search) ?>"</span>
            <span class="badge bg-primary"><?= count($results) ?> found</span>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($results)): ?>
                <div class="table-responsive">
                    <table class="table table-hover compact-table mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Student Number</th>
                                <th>Contact</th>
                                <th>Dormitory</th>
                                <th>Assignment Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $student): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= esc($student['full_name'] ?? 'N/A') ?></div>
                                    </td>
                                    <td><?= esc($student['student_number'] ?? 'N/A') ?></td>
                                    <td>
                                        <?php if (!empty($student['phone'])): ?>
                                            <a href="tel:<?= esc($student['phone']) ?>"><?= esc($student['phone']) ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($student['room_name'])): ?>
                                            <div class="fw-bold"><?= esc($student['room_name']) ?></div>
                                            <small class="text-muted"><?= esc($student['location']) ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">Not assigned</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($student['assignment_id'])): ?>
                                            <span class="badge bg-success">Assigned</span>
                                            <br><small class="text-muted">Since: <?= $student['start_date'] ?></small>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No Assignment</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center table-actions">
                                        <a href="<?= base_url('dormitory/student/' . $student['student_id']) ?>" 
                                           class="btn btn-sm btn-info text-white" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-person-x fs-1"></i>
                    <h5 class="mt-3">No students found</h5>
                    <p>Try searching with a different name or student number.</p>
                </div>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<?= $this->endSection() ?>

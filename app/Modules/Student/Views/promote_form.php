<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold">Promote Students from Admissions</h4>
            <a href="<?= base_url('student') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <?php if (session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif ?>

        <?php if (session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-x-circle me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif ?>

        <?php if (session('results')): ?>
        <div class="card mb-4 border-info">
            <div class="card-header bg-info text-white">
                <i class="bi bi-list-check me-2"></i>Batch Promotion Results
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach (session('results') as $key => $value): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><?= ucfirst(str_replace('_', ' ', $key)) ?></span>
                        <strong class="<?= $key === 'failed' && $value > 0 ? 'text-danger' : 'text-success' ?>"><?= $value ?></strong>
                    </li>
                    <?php endforeach ?>
                </ul>
                <?php if (!empty(session('created_accounts'))): ?>
                <div class="mt-3">
                    <h6>Created Accounts:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (session('created_accounts') as $account): ?>
                                <tr>
                                    <td><?= esc($account['name']) ?></td>
                                    <td><code><?= esc($account['username']) ?></code></td>
                                    <td><code><?= esc($account['password']) ?></code></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
        <?php endif ?>

        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-dark">
                    <i class="bi bi-person-badge me-2"></i>Approved Admissions Ready for Promotion
                </h6>
                <span class="badge bg-primary"><?= count($admissions) ?> records</span>
            </div>
            <div class="card-body">
                <?php if (empty($admissions)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        No approved admissions available for promotion. Admissions must be approved first before they can be promoted to students.
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('student/do-promote') ?>" method="post" id="promoteForm">
                        <?= csrf_field() ?>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                <label class="form-check-label fw-bold" for="selectAll">
                                    Select All
                                </label>
                            </div>
                            <div>
                                <span class="text-muted">Selected: <span id="selectedCount">0</span> records</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="admissionsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">
                                            <span class="text-muted">#</span>
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Citizen ID</th>
                                        <th>Program</th>
                                        <th>Status</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admissions as $index => $admission): ?>
                                        <tr class="<?= empty($admission['citizen_id']) || empty($admission['phone']) ? 'table-warning' : '' ?>">
                                            <td>
                                                <?php if (!empty($admission['citizen_id']) && !empty($admission['phone'])): ?>
                                                    <input type="checkbox" name="admission_ids[]" value="<?= $admission['id'] ?>" class="form-check-input admission-checkbox" onchange="updateSelectedCount()">
                                                <?php else: ?>
                                                    <i class="bi bi-exclamation-triangle text-warning" title="Missing citizen_id or phone"></i>
                                                <?php endif ?>
                                            </td>
                                            <td class="fw-bold"><?= esc($admission['full_name']) ?></td>
                                            <td><?= esc($admission['email']) ?></td>
                                            <td>
                                                <?php if (empty($admission['phone'])): ?>
                                                    <span class="text-danger"><i class="bi bi-exclamation-circle"></i> Missing</span>
                                                <?php else: ?>
                                                    <?= esc($admission['phone']) ?>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <?php if (empty($admission['citizen_id'])): ?>
                                                    <span class="text-danger"><i class="bi bi-exclamation-circle"></i> Missing</span>
                                                <?php else: ?>
                                                    <?= esc($admission['citizen_id']) ?>
                                                <?php endif ?>
                                            </td>
                                            <td><?= esc($admission['program_title'] ?? 'N/A') ?></td>
                                            <td>
                                                <span class="badge bg-success"><?= ucfirst($admission['status']) ?></span>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?= date('M d, Y', strtotime($admission['created_at'])) ?></small>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> Rows highlighted in yellow are missing required fields (Citizen ID or Phone) and cannot be promoted. Please update the profile first.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('student') ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4" id="submitBtn" disabled>
                                <i class="bi bi-check-circle me-2"></i>Promote Selected (<span id="submitCount">0</span>)
                            </button>
                        </div>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.admission-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.admission-checkbox:checked');
    const count = checkboxes.length;
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('submitCount').textContent = count;
    document.getElementById('submitBtn').disabled = count === 0;
}
</script>
<?= $this->endSection() ?>

<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold">Edit User Roles</h4>
            <p class="text-muted mb-0">Manage roles and permissions for <?= esc($user->username) ?></p>
        </div>
        <div class="col-auto">
            <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Username</label>
                        <p class="mb-0 fw-bold"><?= esc($user->username) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">
                            <?php
                            $identities = $user->getEmailIdentity();
                            echo esc($identities->secret ?? '-');
                            ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Status</label>
                        <p class="mb-0">
                            <?php if ($user->active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Last Active</label>
                        <p class="mb-0">
                            <?= $user->last_active ? date('M d, Y H:i', strtotime($user->last_active->format('Y-m-d H:i:s'))) : 'Never' ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Created</label>
                        <p class="mb-0">
                            <?= date('M d, Y', strtotime($user->created_at->format('Y-m-d H:i:s'))) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Assign Roles</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('users/update/' . $user->id) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <p class="text-muted mb-3">
                            Select one or more roles for this user. Each role has different permissions and access levels.
                        </p>

                        <?php foreach ($availableGroups as $groupKey => $groupInfo): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="groups[]" 
                                               value="<?= esc($groupKey) ?>" 
                                               id="group_<?= esc($groupKey) ?>"
                                               <?= in_array($groupKey, $userGroups) ? 'checked' : '' ?>>
                                        <label class="form-check-label w-100" for="group_<?= esc($groupKey) ?>">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1"><?= esc($groupInfo['title']) ?></h6>
                                                    <p class="text-muted small mb-0"><?= esc($groupInfo['description']) ?></p>
                                                </div>
                                                <?php if (in_array($groupKey, $userGroups)): ?>
                                                    <span class="badge bg-success">Current</span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <?php 
                                            // Show permissions for this group
                                            $authGroups = config('AuthGroups');
                                            if (isset($authGroups->matrix[$groupKey])): 
                                            ?>
                                                <div class="mt-2">
                                                    <small class="text-muted">Permissions:</small>
                                                    <div class="mt-1">
                                                        <?php foreach ($authGroups->matrix[$groupKey] as $permission): ?>
                                                            <span class="badge bg-secondary me-1 mb-1"><?= esc($permission) ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update Roles
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

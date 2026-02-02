<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1 class="h3 mb-0">User Management</h1>
            <p class="text-muted">Manage user accounts and roles</p>
        </div>
    </div>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td>
                                    <?php
                                    $userEntity = model('CodeIgniter\Shield\Models\UserModel')->findById($user['id']);
                                    $identities = $userEntity->getEmailIdentity();
                                    echo esc($identities->secret ?? '-');
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($user['groups'])): ?>
                                        <?php foreach ($user['groups'] as $group): ?>
                                            <span class="badge bg-primary"><?= esc(ucfirst($group)) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No Role</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['active']): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $user['last_active'] ? date('M d, Y H:i', strtotime($user['last_active'])) : 'Never' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('users/edit/' . $user['id']) ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit Roles
                                    </a>
                                    <a href="<?= base_url('users/toggle-status/' . $user['id']) ?>" 
                                       class="btn btn-sm btn-<?= $user['active'] ? 'warning' : 'success' ?>"
                                       onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-<?= $user['active'] ? 'x-circle' : 'check-circle' ?>"></i>
                                        <?= $user['active'] ? 'Deactivate' : 'Activate' ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

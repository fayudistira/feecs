<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3>Welcome to the Dashboard</h3>
            <p class="lead">Select a module from the sidebar to get started.</p>
        </div>
    </div>
    
    <!-- Dashboard Stats -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-people"></i> Users
                    </h5>
                    <p class="card-text display-6">-</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-file-earmark-text"></i> Applications
                    </h5>
                    <p class="card-text display-6">-</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-clock-history"></i> Pending
                    </h5>
                    <p class="card-text display-6">-</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-check-circle"></i> Approved
                    </h5>
                    <p class="card-text display-6">-</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <h4>Quick Actions</h4>
            <div class="list-group">
                <?php if (isset($menuItems) && !empty($menuItems)): ?>
                    <?php foreach ($menuItems as $item): ?>
                        <?php if ($item['url'] !== 'dashboard'): ?>
                            <a href="<?= base_url($item['url']) ?>" class="list-group-item list-group-item-action">
                                <i class="bi bi-<?= esc($item['icon'] ?? 'circle') ?>"></i>
                                <?= esc($item['title']) ?>
                            </a>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php else: ?>
                    <div class="list-group-item">
                        <p class="mb-0 text-muted">No modules available. Please contact your administrator.</p>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

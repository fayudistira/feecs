<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<div class="bg-light py-2 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item active">Dormitory</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Page Header -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--dark-red);">Our Dormitory</h1>
        <p class="text-muted">Comfortable and affordable accommodation for students</p>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Search dormitory...">
                <select class="form-select" id="statusFilter" style="max-width: 150px;">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="full">Full</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Dormitory Grid -->
    <?php if (!empty($dormitories)): ?>
        <div class="row g-4" id="dormitoryGrid">
            <?php foreach ($dormitories as $dorm): ?>
                <?php 
                // Get random thumbnail from gallery
                $thumbnail = !empty($dorm['gallery']) ? $dorm['gallery'][array_rand($dorm['gallery'])] : null;
                ?>
                <div class="col-md-6 col-lg-4 dormitory-item" 
                     data-status="<?= $dorm['status'] ?>"
                     data-name="<?= strtolower($dorm['room_name']) ?>">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <!-- Image -->
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            <?php if ($thumbnail): ?>
                                <img src="<?= base_url('uploads/' . $thumbnail) ?>" 
                                     class="card-img-top w-100 h-100" 
                                     style="object-fit: cover;"
                                     alt="<?= esc($dorm['room_name']) ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-building fs-1 text-muted"></i>
                                </div>
                            <?php endif ?>
                            
                            <!-- Status Badge -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <?php if ($dorm['status'] === 'available'): ?>
                                    <?php if ($dorm['available_beds'] > 0): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i><?= $dorm['available_beds'] ?> Available
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Limited</span>
                                    <?php endif ?>
                                <?php elseif ($dorm['status'] === 'full'): ?>
                                    <span class="badge bg-warning text-dark">Full</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Maintenance</span>
                                <?php endif ?>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= esc($dorm['room_name']) ?></h5>
                            <p class="card-text text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i><?= esc($dorm['location']) ?>
                            </p>
                            
                            <!-- Capacity Info -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted">Capacity</small>
                                    <div class="fw-bold"><?= $dorm['room_capacity'] ?> beds</div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Occupied</small>
                                    <div class="fw-bold text-danger"><?= $dorm['occupied_beds'] ?></div>
                                </div>
                            </div>
                            
                            <!-- Facilities Preview -->
                            <?php if (!empty($dorm['facilities'])): ?>
                                <div class="mb-3">
                                    <?php foreach (array_slice($dorm['facilities'], 0, 3) as $facility): ?>
                                        <span class="badge bg-light text-dark me-1 mb-1">
                                            <i class="bi bi-check2 text-success me-1"></i><?= esc($facility) ?>
                                        </span>
                                    <?php endforeach ?>
                                    <?php if (count($dorm['facilities']) > 3): ?>
                                        <span class="badge bg-light text-dark">+<?= count($dorm['facilities']) - 3 ?> more</span>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                            
                            <a href="<?= base_url('dormitories/' . $dorm['id']) ?>" 
                               class="btn btn-outline-danger w-100">
                                View Details <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-building fs-1 text-muted"></i>
            <h4 class="mt-3 text-muted">No dormitories available</h4>
            <p class="text-muted">Please check back later for available rooms.</p>
        </div>
    <?php endif ?>
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
</style>

<script>
// Search and filter functionality
document.getElementById('searchInput').addEventListener('keyup', filterDormitories);
document.getElementById('statusFilter').addEventListener('change', filterDormitories);

function filterDormitories() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const items = document.querySelectorAll('.dormitory-item');
    
    items.forEach(item => {
        const name = item.dataset.name;
        const itemStatus = item.dataset.status;
        
        const matchSearch = name.includes(search);
        const matchStatus = !status || itemStatus === status;
        
        item.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}
</script>
<?= $this->endSection() ?>

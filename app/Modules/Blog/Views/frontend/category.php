<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('title') ?>
<?= $metaTitle ?? 'Category: ' . ($category['name'] ?? 'Blog') ?>
<?= $this->endSection() ?>

<?= $this->section('meta') ?>
<meta name="description" content="<?= $metaDescription ?? 'Browse articles in ' . ($category['name'] ?? 'category') ?>">
<?php if (!empty($metaKeywords)): ?>
<meta name="keywords" content="<?= esc($metaKeywords) ?>">
<?php endif; ?>
<!-- Open Graph -->
<meta property="og:title" content="<?= $metaTitle ?? 'Category: ' . ($category['name'] ?? 'Blog') ?>">
<meta property="og:description" content="<?= $metaDescription ?? 'Browse articles in ' . ($category['name'] ?? 'category') ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= current_url() ?>">
<!-- Twitter Card -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?= $metaTitle ?? 'Category: ' . ($category['name'] ?? 'Blog') ?>">
<meta name="twitter:description" content="<?= $metaDescription ?? 'Browse articles in ' . ($category['name'] ?? 'category') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3"><?= esc($category['name'] ?? 'Category') ?></h1>
                <p class="lead text-muted"><?= esc($category['description'] ?? 'Browse articles in this category') ?></p>
            </div>
            <div class="col-lg-4">
                <form action="<?= base_url('blog/search') ?>" method="get" class="d-flex">
                    <input type="text" name="q" class="form-control me-2" placeholder="Search articles..." 
                           value="<?= service('request')->getGet('q') ?? '' ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                <article class="card mb-4 border-0 shadow-sm">
                    <?php if (!empty($post['featured_image'])): ?>
                    <a href="<?= base_url('blog/' . $post['slug']) ?>">
                        <img src="<?= esc($post['featured_image']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>" style="height: 250px; object-fit: cover;">
                    </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="mb-2">
                            <?php if (!empty($post['categories'])): ?>
                                <?php foreach ($post['categories'] as $cat): ?>
                                <a href="<?= base_url('blog/category/' . $cat['slug']) ?>" class="badge bg-primary text-decoration-none">
                                    <?= esc($cat['name']) ?>
                                </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <h2 class="card-title h4">
                            <a href="<?= base_url('blog/' . $post['slug']) ?>" class="text-decoration-none text-dark">
                                <?= esc($post['title']) ?>
                            </a>
                        </h2>
                        <p class="card-text text-muted"><?= esc($post['excerpt'] ?? strip_tags(mb_substr($post['content'] ?? '', 0, 200))) ?>...</p>
                        <div class="d-flex align-items-center text-muted small">
                            <span class="me-3">
                                <i class="bi bi-calendar me-1"></i>
                                <?= date('M d, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?>
                            </span>
                            <span class="me-3">
                                <i class="bi bi-eye me-1"></i>
                                <?= number_format($post['view_count'] ?? 0) ?> views
                            </span>
                            <?php if (!empty($post['author_name'])): ?>
                            <span>
                                <i class="bi bi-person me-1"></i>
                                <?= esc($post['author_name']) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
                <nav>
                    <?= $pager->links() ?>
                </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    No posts found in this category.
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Categories -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-folder me-2"></i>Categories</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($categories)): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($categories as $cat): ?>
                        <li class="mb-2">
                            <a href="<?= base_url('blog/category/' . $cat['slug']) ?>" class="text-decoration-none d-flex justify-content-between align-items-center">
                                <span><?= esc($cat['name']) ?></span>
                                <span class="badge bg-secondary"><?= $cat['post_count'] ?? 0 ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p class="text-muted mb-0">No categories available.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Popular Tags -->
            <?php if (!empty($popularTags)): ?>
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-tags me-2"></i>Popular Tags</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($popularTags as $tag): ?>
                        <a href="<?= base_url('blog/tag/' . $tag['slug']) ?>" class="badge bg-light text-dark text-decoration-none">
                            <?= esc($tag['name']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Recent Posts -->
            <?php if (!empty($recentPosts)): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-clock me-2"></i>Recent Posts</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentPosts as $recentPost): ?>
                        <a href="<?= base_url('blog/' . $recentPost['slug']) ?>" class="list-group-item list-group-item-action d-flex align-items-center">
                            <?php if (!empty($recentPost['featured_image'])): ?>
                            <img src="<?= esc($recentPost['featured_image']) ?>" alt="<?= esc($recentPost['title']) ?>" 
                                 class="me-3 rounded" style="width: 60px; height: 45px; object-fit: cover;">
                            <?php endif; ?>
                            <div>
                                <h6 class="mb-0 text-truncate" style="max-width: 200px;"><?= esc($recentPost['title']) ?></h6>
                                <small class="text-muted"><?= date('M d, Y', strtotime($recentPost['published_at'] ?? $recentPost['created_at'])) ?></small>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

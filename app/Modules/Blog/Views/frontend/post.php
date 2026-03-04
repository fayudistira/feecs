<?= $this->extend('Modules\Frontend\Views\layout') ?>

<?= $this->section('title') ?>
<?= $metaTitle ?? esc($post['title']) ?>
<?= $this->endSection() ?>

<?= $this->section('meta') ?>
<meta name="description" content="<?= $metaDescription ?? esc($post['excerpt'] ?? '') ?>">
<?php if (!empty($metaKeywords)): ?>
<meta name="keywords" content="<?= esc($metaKeywords) ?>">
<?php endif; ?>
<meta name="author" content="<?= esc($post['author_name'] ?? 'Admin') ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= $ogTitle ?? esc($post['meta_title'] ?? $post['title']) ?>">
<meta property="og:description" content="<?= $ogDescription ?? esc($post['meta_description'] ?? $post['excerpt'] ?? '') ?>">
<meta property="og:type" content="article">
<meta property="og:url" content="<?= $ogUrl ?? current_url() ?>">
<meta property="article:published_time" content="<?= date('c', strtotime($post['published_at'])) ?>">
<meta property="article:modified_time" content="<?= date('c', strtotime($post['updated_at'])) ?>">
<?php if (!empty($ogImage)): ?>
<meta property="og:image" content="<?= $ogImage ?>">
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="<?= $twitterCard ?? 'summary' ?>">
<meta name="twitter:title" content="<?= $ogTitle ?? esc($post['title']) ?>">
<meta name="twitter:description" content="<?= $ogDescription ?? esc($post['excerpt'] ?? '') ?>">
<?php if (!empty($ogImage)): ?>
<meta name="twitter:image" content="<?= $ogImage ?>">
<?php endif; ?>

<!-- Schema.org Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "<?= esc($post['title']) ?>",
    "image": <?= !empty($post['featured_image']) ? '"' . esc($post['featured_image']) . '"' : '""' ?>,
    "datePublished": "<?= date('c', strtotime($post['published_at'])) ?>",
    "dateModified": "<?= date('c', strtotime($post['updated_at'])) ?>",
    "author": {
        "@type": "Person",
        "name": "<?= esc($post['author_name'] ?? 'Admin') ?>"
    },
    "description": "<?= esc($post['excerpt'] ?? '') ?>"
}
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Article Header -->
<article class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('blog') ?>">Blog</a></li>
                        <?php if (!empty($post['category_name'])): ?>
                        <li class="breadcrumb-item"><a href="<?= base_url('blog/category/' . $post['category_slug']) ?>"><?= esc($post['category_name']) ?></a></li>
                        <?php endif; ?>
                        <li class="breadcrumb-item active"><?= esc($post['title']) ?></li>
                    </ol>
                </nav>

                <!-- Post Title -->
                <h1 class="display-4 fw-bold mb-3"><?= esc($post['title']) ?></h1>

                <!-- Post Meta -->
                <div class="d-flex flex-wrap gap-3 mb-4 text-muted">
                    <span><i class="bi bi-person me-1"></i><?= esc($post['author_name'] ?? 'Admin') ?></span>
                    <span><i class="bi bi-calendar me-1"></i><?= date('F d, Y', strtotime($post['published_at'])) ?></span>
                    <?php if (!empty($post['reading_time'])): ?>
                    <span><i class="bi bi-clock me-1"></i><?= $post['reading_time'] ?> min read</span>
                    <?php endif; ?>
                    <span><i class="bi bi-eye me-1"></i><?= number_format($post['view_count']) ?> views</span>
                </div>

                <!-- Category & Tags -->
                <div class="mb-4">
                    <?php if (!empty($post['category_name'])): ?>
                    <a href="<?= base_url('blog/category/' . $post['category_slug']) ?>" class="badge bg-primary text-decoration-none me-2">
                        <?= esc($post['category_name']) ?>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($post['tags'])): ?>
                        <?php foreach ($post['tags'] as $tag): ?>
                        <a href="<?= base_url('blog/tag/' . $tag['slug']) ?>" class="badge bg-light text-dark text-decoration-none me-1">
                            <?= esc($tag['name']) ?>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Featured Image -->
                <?php if (!empty($post['featured_image'])): ?>
                <div class="mb-5">
                    <img src="<?= esc($post['featured_image']) ?>" alt="<?= esc($post['title']) ?>" class="img-fluid rounded shadow-sm" style="width: 100%; max-height: 500px; object-fit: cover;">
                </div>
                <?php endif; ?>

                <!-- AI Summary (if available) -->
                <?php if (!empty($post['ai_summary'])): ?>
                <div class="alert alert-info mb-4">
                    <h6 class="alert-heading"><i class="bi bi-magic me-2"></i>AI Summary</h6>
                    <p class="mb-0"><?= esc($post['ai_summary']) ?></p>
                </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="blog-content fs-5 lh-lg">
                    <?= $post['content'] ?>
                </div>

                <!-- Share Buttons -->
                <div class="border-top border-bottom py-4 mt-5 mb-5">
                    <div class="d-flex align-items-center">
                        <span class="me-3">Share this article:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="mailto:?subject=<?= urlencode($post['title']) ?>&body=<?= urlencode(current_url()) ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="card border-0 shadow-sm mb-5">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-person fs-3 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1"><?= esc($post['author_name'] ?? 'Admin') ?></h5>
                                <p class="text-muted mb-0">Author</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Related Posts -->
<?php if (!empty($relatedPosts)): ?>
<section class="bg-light py-5">
    <div class="container">
        <h3 class="mb-4">Related Articles</h3>
        <div class="row">
            <?php foreach ($relatedPosts as $related): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <?php if (!empty($related['featured_image'])): ?>
                    <img src="<?= esc($related['featured_image']) ?>" class="card-img-top" alt="<?= esc($related['title']) ?>" style="height: 150px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h6 class="card-title">
                            <a href="<?= base_url('blog/' . $related['slug']) ?>" class="text-decoration-none text-dark">
                                <?= esc($related['title']) ?>
                            </a>
                        </h6>
                        <p class="card-text small text-muted">
                            <?= esc($related['excerpt'] ?? substr(strip_tags($related['content']), 0, 80)) ?>...
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Sidebar Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <!-- Categories -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Categories</h6>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($categories)): ?>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($categories as $category): ?>
                                    <li class="mb-2">
                                        <a href="<?= base_url('blog/category/' . $category['slug']) ?>" class="text-decoration-none">
                                            <?= esc($category['name']) ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Recent Articles</h6>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recentPosts)): ?>
                                <?php foreach ($recentPosts as $recent): ?>
                                <div class="mb-3">
                                    <a href="<?= base_url('blog/' . $recent['slug']) ?>" class="text-decoration-none">
                                        <h6 class="mb-1"><?= esc($recent['title']) ?></h6>
                                    </a>
                                    <small class="text-muted"><?= date('M d, Y', strtotime($recent['published_at'])) ?></small>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

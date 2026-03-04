<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col">
        <h4 class="fw-bold mb-1">Edit Post</h4>
        <p class="text-muted mb-0">Update your educational blog article</p>
    </div>
    <div class="col-auto">
        <a href="<?= base_url('admin/blog') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Posts
        </a>
        <a href="<?= base_url('blog/' . $post['slug']) ?>" target="_blank" class="btn btn-outline-info">
            <i class="bi bi-eye me-1"></i> View Post
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="<?= base_url('admin/blog/update/' . $post['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= esc($post['title']) ?>" required
                               placeholder="Enter blog post title">
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('blog/') ?></span>
                            <input type="text" class="form-control" id="slug" name="slug" 
                                   value="<?= esc($post['slug']) ?>">
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="15" required
                                  placeholder="Write your blog content here..."><?= esc($post['content']) ?></textarea>
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3"
                                  placeholder="Short description for previews"><?= esc($post['excerpt'] ?? '') ?></textarea>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image URL</label>
                        <input type="url" class="form-control" id="featured_image" name="featured_image" 
                               value="<?= esc($post['featured_image'] ?? '') ?>"
                               placeholder="https://example.com/image.jpg">
                        <?php if (!empty($post['featured_image'])): ?>
                            <div class="mt-2">
                                <img src="<?= $post['featured_image'] ?>" alt="Featured Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Publish Settings -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Publish</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Select Category</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= ($post['category_id'] ?? null) == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <select class="form-select" id="tags" name="tags[]" multiple>
                        <?php if (!empty($tags)): ?>
                            <?php foreach ($tags as $tag): ?>
                                <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $postTags ?? []) ? 'selected' : '' ?>>
                                    <?= esc($tag['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="published_at" class="form-label">Publish Date</label>
                    <input type="datetime-local" class="form-control" id="published_at" name="published_at" 
                           value="<?= !empty($post['published_at']) ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : '' ?>">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" 
                           <?= ($post['is_published'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                           <?= ($post['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg me-1"></i> Update Post
                </button>
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">SEO Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" 
                           value="<?= esc($post['meta_title'] ?? '') ?>" maxlength="70">
                    <div class="form-text"><span id="meta_title_count"><?= strlen($post['meta_title'] ?? '') ?></span>/70 characters</div>
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                              maxlength="160"><?= esc($post['meta_description'] ?? '') ?></textarea>
                    <div class="form-text"><span id="meta_description_count"><?= strlen($post['meta_description'] ?? '') ?></span>/160 characters</div>
                </div>

                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                           value="<?= esc($post['meta_keywords'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- AI Features -->
        <?php if (config('Blog')->enableAI): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">AI Assistant</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2" id="ai_generate_summary">
                    <i class="bi bi-magic me-1"></i> Generate Summary
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm w-100" id="ai_extract_keywords">
                    <i class="bi bi-tags me-1"></i> Extract Keywords
                </button>
            </div>
        </div>
        <?php endif; ?>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('blur', function() {
        if (!slugInput.value) {
            slugInput.value = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        }
    });

    // Character count for meta fields
    const metaTitle = document.getElementById('meta_title');
    const metaTitleCount = document.getElementById('meta_title_count');
    if (metaTitle) {
        metaTitle.addEventListener('input', function() {
            metaTitleCount.textContent = this.value.length;
        });
    }

    const metaDesc = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('meta_description_count');
    if (metaDesc) {
        metaDesc.addEventListener('input', function() {
            metaDescCount.textContent = this.value.length;
        });
    }

    // AI Features
    const generateSummaryBtn = document.getElementById('ai_generate_summary');
    if (generateSummaryBtn) {
        generateSummaryBtn.addEventListener('click', function() {
            const content = document.getElementById('content').value;
            if (!content) {
                alert('Please enter some content first');
                return;
            }
            
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Generating...';
            
            fetch('<?= base_url('admin/blog/ai/generate-summary') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-Token': '<?= csrf_hash() ?>'
                },
                body: 'content=' + encodeURIComponent(content)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('excerpt').value = data.summary;
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = '<i class="bi bi-magic me-1"></i> Generate Summary';
            });
        });
    }

    const extractKeywordsBtn = document.getElementById('ai_extract_keywords');
    if (extractKeywordsBtn) {
        extractKeywordsBtn.addEventListener('click', function() {
            const content = document.getElementById('content').value;
            if (!content) {
                alert('Please enter some content first');
                return;
            }
            
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Extracting...';
            
            fetch('<?= base_url('admin/blog/ai/extract-keywords') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-Token': '<?= csrf_hash() ?>'
                },
                body: 'content=' + encodeURIComponent(content)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('meta_keywords').value = data.keywords;
                }
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = '<i class="bi bi-tags me-1"></i> Extract Keywords';
            });
        });
    }
});
</script>

<?= $this->endSection() ?>

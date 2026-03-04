<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col">
        <h4 class="fw-bold mb-1">Create New Post</h4>
        <p class="text-muted mb-0">Write a new educational blog article</p>
    </div>
    <div class="col-auto">
        <a href="<?= base_url('admin/blog') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Posts
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="<?= base_url('admin/blog/store') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= old('title') ?>" required
                               placeholder="Enter blog post title">
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text"><?= base_url('blog/') ?></span>
                            <input type="text" class="form-control" id="slug" name="slug" 
                                   value="<?= old('slug') ?>"
                                   placeholder="auto-generated-if-empty">
                        </div>
                        <div class="form-text">Alphanumeric characters, dashes, and underscores only</div>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="15" required
                                  placeholder="Write your blog content here..."><?= old('content') ?></textarea>
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3"
                                  placeholder="Short description for previews (optional)"><?= old('excerpt') ?></textarea>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image URL</label>
                        <input type="url" class="form-control" id="featured_image" name="featured_image" 
                               value="<?= old('featured_image') ?>"
                               placeholder="https://example.com/image.jpg">
                        <?php if (old('featured_image')): ?>
                            <div class="mt-2">
                                <img src="<?= old('featured_image') ?>" alt="Featured Preview" class="img-thumbnail" style="max-height: 200px;">
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
                                <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
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
                                <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], old('tags', [])) ? 'selected' : '' ?>>
                                    <?= esc($tag['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <div class="form-text">Hold Ctrl/Cmd to select multiple</div>
                </div>

                <div class="mb-3">
                    <label for="published_at" class="form-label">Publish Date</label>
                    <input type="datetime-local" class="form-control" id="published_at" name="published_at" 
                           value="<?= old('published_at') ?>">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" 
                           <?= old('is_published') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_published">Publish immediately</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                           <?= old('is_featured') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_featured">Feature this post</label>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg me-1"></i> Create Post
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
                           value="<?= old('meta_title') ?>" maxlength="70"
                           placeholder="SEO title (recommended: 60-70 characters)">
                    <div class="form-text"><span id="meta_title_count">0</span>/70 characters</div>
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                              maxlength="160" placeholder="SEO description (recommended: 150-160 characters)"><?= old('meta_description') ?></textarea>
                    <div class="form-text"><span id="meta_description_count">0</span>/160 characters</div>
                </div>

                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                           value="<?= old('meta_keywords') ?>"
                           placeholder="keyword1, keyword2, keyword3">
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
        metaTitleCount.textContent = metaTitle.value.length;
    }

    const metaDesc = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('meta_description_count');
    if (metaDesc) {
        metaDesc.addEventListener('input', function() {
            metaDescCount.textContent = this.value.length;
        });
        metaDescCount.textContent = metaDesc.value.length;
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
            .catch(error => {
                alert('Error generating summary');
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
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error extracting keywords');
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

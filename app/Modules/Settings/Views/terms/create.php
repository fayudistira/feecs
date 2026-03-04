<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>

<!-- Custom WYSIWYG Editor CSS -->
<style>
.wysiwyg-editor {
    border: 1px solid #ced4da;
    border-radius: 0 0 0.375rem 0.375rem;
    min-height: 400px;
    max-height: 500px;
    padding: 1rem;
    background: #fff;
    overflow-y: auto;
}

.wysiwyg-editor:focus {
    outline: none;
    border-color: #8B0000;
    box-shadow: 0 0 0 0.2rem rgba(139, 0, 0, 0.15);
}

.wysiwyg-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    padding: 0.5rem;
    background: #f8f9fa;
    border: 1px solid #ced4da;
    border-bottom: none;
    border-radius: 0.375rem 0.375rem 0 0;
}

.wysiwyg-toolbar button {
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    background: #fff;
    border-radius: 0.2rem;
    cursor: pointer;
    font-size: 0.875rem;
    transition: all 0.15s ease;
}

.wysiwyg-toolbar button:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.wysiwyg-toolbar button.active {
    background: #8B0000;
    color: #fff;
    border-color: #8B0000;
}

.wysiwyg-toolbar .separator {
    width: 1px;
    background: #ced4da;
    margin: 0 0.25rem;
}

.wysiwyg-editor ul, .wysiwyg-editor ol {
    padding-left: 1.5rem;
}

.wysiwyg-editor a {
    color: #8B0000;
    text-decoration: underline;
}

.wysiwyg-editor h1, .wysiwyg-editor h2, .wysiwyg-editor h3 {
    color: #333;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}
</style>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col">
        <h4 class="fw-bold mb-1">Create New Terms & Conditions</h4>
        <p class="text-muted mb-0">Add terms and conditions for a specific language</p>
    </div>
    <div class="col-auto">
        <a href="<?= base_url('settings/terms') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Terms List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">

<!-- Error Messages -->
<?php if (session('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Validation Errors:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Create Form -->
<form action="<?= base_url('settings/terms/store') ?>" method="post" id="termsForm">
    <?= csrf_field() ?>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <i class="bi bi-file-text me-2"></i>Terms Content
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Language <span class="text-danger">*</span></label>
                        <select name="language" class="form-select form-select-sm" required>
                            <option value="">Select Language</option>
                            <?php foreach ($availableLanguages as $lang): ?>
                                <?php if (!in_array($lang['language'], $existingLanguages)): ?>
                                    <option value="<?= esc($lang['language']) ?>">
                                        <?= esc($lang['language']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">This should match the language in your programs</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-sm" 
                               value="<?= old('title') ?>" required
                               placeholder="e.g., Terms and Conditions">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        
                        <!-- Editor Toggle -->
                        <div class="d-flex justify-content-end mb-2">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Editor mode">
                                <input type="radio" class="btn-check" name="editorMode" id="modeVisual" value="visual" checked>
                                <label class="btn btn-outline-secondary" for="modeVisual">
                                    <i class="bi bi-eye me-1"></i>Visual
                                </label>
                                <input type="radio" class="btn-check" name="editorMode" id="modeCode" value="code">
                                <label class="btn btn-outline-secondary" for="modeCode">
                                    <i class="bi bi-code-slash me-1"></i>Code
                                </label>
                            </div>
                        </div>
                        
                        <!-- Visual Editor (WYSIWYG) -->
                        <div id="visualEditorContainer">
                            <div class="wysiwyg-toolbar">
                            <button type="button" onclick="execCmd('bold')" title="Bold"><i class="bi bi-type-bold"></i></button>
                            <button type="button" onclick="execCmd('italic')" title="Italic"><i class="bi bi-type-italic"></i></button>
                            <button type="button" onclick="execCmd('underline')" title="Underline"><i class="bi bi-type-underline"></i></button>
                            <button type="button" onclick="execCmd('strikeThrough')" title="Strikethrough"><i class="bi bi-type-strikethrough"></i></button>
                            <div class="separator"></div>
                            <button type="button" onclick="execCmd('insertUnorderedList')" title="Bullet List"><i class="bi bi-list-ul"></i></button>
                            <button type="button" onclick="execCmd('insertOrderedList')" title="Numbered List"><i class="bi bi-list-ol"></i></button>
                            <div class="separator"></div>
                            <button type="button" onclick="execCmd('formatBlock', 'h2')" title="Heading 2">H2</button>
                            <button type="button" onclick="execCmd('formatBlock', 'h3')" title="Heading 3">H3</button>
                            <button type="button" onclick="execCmd('formatBlock', 'p')" title="Paragraph">P</button>
                            <div class="separator"></div>
                            <button type="button" onclick="execCmd('justifyLeft')" title="Align Left"><i class="bi bi-text-left"></i></button>
                            <button type="button" onclick="execCmd('justifyCenter')" title="Align Center"><i class="bi bi-text-center"></i></button>
                            <button type="button" onclick="execCmd('justifyRight')" title="Align Right"><i class="bi bi-text-right"></i></button>
                            <div class="separator"></div>
                            <button type="button" onclick="insertLink()" title="Insert Link"><i class="bi bi-link-45deg"></i></button>
                            <button type="button" onclick="execCmd('removeFormat')" title="Clear Formatting"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div id="contentEditor" class="wysiwyg-editor" contenteditable="true" data-placeholder="Enter terms and conditions content..."><?= old('content') ?></div>
                        
                        <!-- Code Editor (HTML Source) -->
                        <div id="codeEditorContainer" style="display: none;">
                            <textarea id="codeEditor" class="form-control" rows="20" style="font-family: monospace; font-size: 13px;" placeholder="Enter HTML code..."></textarea>
                        </div>
                        
                        <input type="hidden" name="content" id="contentInput">
                        <small class="text-muted">Use the toolbar above to format your content</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>Settings
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   id="isActive" value="1" checked>
                            <label class="form-check-label" for="isActive">
                                Active
                            </label>
                        </div>
                        <small class="text-muted">Inactive terms won't be shown to applicants</small>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-dark-red w-100 mb-2">
                        <i class="bi bi-save me-1"></i> Create Terms
                    </button>
                    <a href="<?= base_url('settings/terms') ?>" class="btn btn-outline-secondary w-100">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// WYSIWYG Editor Functions
function execCmd(command, value = null) {
    document.execCommand(command, false, value);
    document.getElementById('contentEditor').focus();
    updateToolbarState();
}

function insertLink() {
    var url = prompt('Enter URL:');
    if (url) {
        document.execCommand('createLink', false, url);
    }
}

function updateToolbarState() {
    // Update button states based on current formatting
    var buttons = document.querySelectorAll('.wysiwyg-toolbar button');
    buttons.forEach(function(btn) {
        var command = btn.getAttribute('onclick');
        if (command && command.includes('execCmd')) {
            var cmd = command.match(/execCmd\('(\w+)'/);
            if (cmd && document.queryCommandState(cmd[1])) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }
    });
}

// Listen for selection changes to update toolbar
document.addEventListener('selectionchange', function() {
    updateToolbarState();
});

// Sync content before form submission
document.getElementById('termsForm').addEventListener('submit', function(e) {
    var mode = document.querySelector('input[name="editorMode"]:checked').value;
    var content;
    
    if (mode === 'visual') {
        content = document.getElementById('contentEditor').innerHTML;
    } else {
        content = document.getElementById('codeEditor').value;
    }
    
    document.getElementById('contentInput').value = content;
    
    // Check if content is empty
    if (content.trim() === '' || content === '<br>') {
        e.preventDefault();
        alert('Please enter content for the terms and conditions.');
        return false;
    }
});

// Editor mode toggle
document.querySelectorAll('input[name="editorMode"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var visualContainer = document.getElementById('visualEditorContainer');
        var codeContainer = document.getElementById('codeEditorContainer');
        
        if (this.value === 'visual') {
            // Switch to visual mode - copy code to visual editor
            visualContainer.style.display = 'block';
            codeContainer.style.display = 'none';
            document.getElementById('contentEditor').innerHTML = document.getElementById('codeEditor').value;
        } else {
            // Switch to code mode - copy visual to code editor
            visualContainer.style.display = 'none';
            codeContainer.style.display = 'block';
            document.getElementById('codeEditor').value = document.getElementById('contentEditor').innerHTML;
        }
    });
});

// Add placeholder support for contenteditable
document.getElementById('contentEditor').addEventListener('focus', function() {
    this.removeAttribute('data-placeholder-active');
});

document.getElementById('contentEditor').addEventListener('blur', function() {
    if (this.innerHTML.trim() === '') {
        this.innerHTML = '';
    }
});
</script>

<?= $this->endSection() ?>

<?php

/**
 * Blog Controller
 * 
 * Handles admin-side blog management including:
 * - CRUD operations for blog posts
 * - Category management
 * - Statistics
 */

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\BlogPostModel;
use Modules\Blog\Models\BlogCategoryModel;
use Modules\Blog\Models\BlogTagModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class BlogController extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $guard;

    public function __construct()
    {
        $this->postModel = new BlogPostModel();
        $this->categoryModel = new BlogCategoryModel();
        $this->tagModel = new BlogTagModel();
        
        // Get current user for author_id
        $this->guard = service('auth')->user();
    }

    /**
     * Dashboard - List all blog posts
     */
    public function index()
    {
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        
        $data['posts'] = $this->postModel->getAllPosts($page, $perPage);
        $data['pager'] = $this->postModel->pager;
        $data['stats'] = $this->postModel->getStats();
        
        return view('Modules\Blog\Views\admin\index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data['categories'] = $this->categoryModel->getAllCategories();
        $data['tags'] = $this->tagModel->getAllTags();
        $data['action'] = 'create';
        
        return view('Modules\Blog\Views\admin\create', $data);
    }

    /**
     * Store new post
     */
    public function store(): RedirectResponse
    {
        $validation = $this->validate([
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'slug' => 'permit_empty|max_length[255]|alpha_dash',
            'category_id' => 'permit_empty|integer',
            'meta_title' => 'max_length[70]',
            'meta_description' => 'max_length[160]',
            'meta_keywords' => 'max_length[255]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $user = service('auth')->user();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?? '',
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'featured_image' => $this->request->getPost('featured_image'),
            'author_id' => $user->id,
            'category_id' => $this->request->getPost('category_id') ?: null,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'published_at' => $this->request->getPost('published_at'),
        ];

        // Process tags
        $tags = $this->request->getPost('tags');
        if ($tags) {
            $tagIds = is_array($tags) ? $tags : explode(',', $tags);
            $data['tags'] = array_filter(array_map('intval', $tagIds));
        }

        try {
            $postId = $this->postModel->createPost($data);
            
            return redirect()->to('admin/blog')
                ->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create post: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form
     */
    public function edit(int $id)
    {
        $post = $this->postModel->find($id);
        
        if (!$post) {
            return redirect()->to('admin/blog')
                ->with('error', 'Blog post not found!');
        }

        $data['post'] = $post;
        $data['categories'] = $this->categoryModel->getAllCategories();
        $data['tags'] = $this->tagModel->getAllTags();
        $data['postTags'] = array_column($this->postModel->getPostTags($id), 'id');
        $data['action'] = 'edit';
        
        return view('Modules\Blog\Views\admin\edit', $data);
    }

    /**
     * Update existing post
     */
    public function update(int $id): RedirectResponse
    {
        $post = $this->postModel->find($id);
        
        if (!$post) {
            return redirect()->to('admin/blog')
                ->with('error', 'Blog post not found!');
        }

        $validation = $this->validate([
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'slug' => 'permit_empty|max_length[255]|alpha_dash',
            'category_id' => 'permit_empty|integer',
            'meta_title' => 'max_length[70]',
            'meta_description' => 'max_length[160]',
            'meta_keywords' => 'max_length[255]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?? '',
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'featured_image' => $this->request->getPost('featured_image'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'published_at' => $this->request->getPost('published_at'),
        ];

        // Process tags
        $tags = $this->request->getPost('tags');
        if ($tags) {
            $tagIds = is_array($tags) ? $tags : explode(',', $tags);
            $data['tags'] = array_filter(array_map('intval', $tagIds));
        }

        try {
            $this->postModel->updatePost($id, $data);
            
            return redirect()->to('admin/blog')
                ->with('success', 'Blog post updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update post: ' . $e->getMessage());
        }
    }

    /**
     * Delete post
     */
    public function delete(int $id): RedirectResponse
    {
        $post = $this->postModel->find($id);
        
        if (!$post) {
            return redirect()->to('admin/blog')
                ->with('error', 'Blog post not found!');
        }

        try {
            $this->postModel->delete($id);
            
            return redirect()->to('admin/blog')
                ->with('success', 'Blog post deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->to('admin/blog')
                ->with('error', 'Failed to delete post: ' . $e->getMessage());
        }
    }

    /**
     * Toggle publish status
     */
    public function toggle(int $id): RedirectResponse
    {
        $post = $this->postModel->find($id);
        
        if (!$post) {
            return redirect()->to('admin/blog')
                ->with('error', 'Blog post not found!');
        }

        $newStatus = $post['is_published'] ? 0 : 1;
        
        $this->postModel->update($id, [
            'is_published' => $newStatus,
            'published_at' => $newStatus ? date('Y-m-d H:i:s') : null,
        ]);

        $status = $newStatus ? 'published' : 'unpublished';
        
        return redirect()->to('admin/blog')
            ->with('success', "Blog post {$status} successfully!");
    }

    /**
     * Toggle featured status
     */
    public function feature(int $id): RedirectResponse
    {
        $post = $this->postModel->find($id);
        
        if (!$post) {
            return redirect()->to('admin/blog')
                ->with('error', 'Blog post not found!');
        }

        $newStatus = $post['is_featured'] ? 0 : 1;
        
        $this->postModel->update($id, ['is_featured' => $newStatus]);

        $status = $newStatus ? 'featured' : 'unfeatured';
        
        return redirect()->to('admin/blog')
            ->with('success', "Blog post {$status} successfully!");
    }

    /**
     * Get blog statistics
     */
    public function stats()
    {
        $data['stats'] = $this->postModel->getStats();
        $data['popularPosts'] = $this->postModel->getPopularPosts(10);
        
        return view('Modules\Blog\Views\admin\stats', $data);
    }

    /**
     * Generate AI summary (placeholder)
     */
    public function generateSummary()
    {
        $content = $this->request->getPost('content');
        
        if (empty($content)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Content is required'
            ]);
        }

        // Placeholder for AI integration
        // In production, this would call OpenAI, Claude, or other AI service
        $summary = $this->generatePlaceholderSummary($content);
        
        return $this->response->setJSON([
            'success' => true,
            'summary' => $summary
        ]);
    }

    /**
     * Extract AI keywords (placeholder)
     */
    public function extractKeywords()
    {
        $content = $this->request->getPost('content');
        
        if (empty($content)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Content is required'
            ]);
        }

        // Placeholder for AI integration
        $keywords = $this->extractPlaceholderKeywords($content);
        
        return $this->response->setJSON([
            'success' => true,
            'keywords' => implode(', ', $keywords)
        ]);
    }

    /**
     * Placeholder summary generation
     */
    private function generatePlaceholderSummary(string $content): string
    {
        $text = strip_tags($content);
        $text = str_replace(['&nbsp;', '&', '"'], [' ', '&', '"'], $text);
        $text = trim($text);
        
        if (strlen($text) <= 150) {
            return $text;
        }
        
        $summary = substr($text, 0, 150);
        $summary = substr($summary, 0, strrpos($summary, ' '));
        
        return $summary . '...';
    }

    /**
     * Placeholder keyword extraction
     */
    private function extractPlaceholderKeywords(string $content): array
    {
        $text = strip_tags(strtolower($content));
        
        // Common words to exclude
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 
            'of', 'with', 'by', 'from', 'as', 'is', 'was', 'are', 'were', 'been', 'be',
            'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should',
            'may', 'might', 'must', 'shall', 'can', 'need', 'dare', 'ought', 'used'];
        
        preg_match_all('/\b[a-z]{3,}\b/', $text, $words);
        
        $wordCounts = array_count_value($words[0]);
        
        foreach ($stopWords as $stop) {
            unset($wordCounts[$stop]);
        }
        
        arsort($wordCounts);
        
        return array_slice(array_keys($wordCounts), 0, 10);
    }
}

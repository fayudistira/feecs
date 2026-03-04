<?php

/**
 * Blog Admin API Controller
 * 
 * Handles admin API endpoints for the blog module.
 * These endpoints require authentication.
 */

namespace Modules\Blog\Controllers\Api;

use Modules\Blog\Models\BlogPostModel;
use Modules\Blog\Models\BlogCategoryModel;
use Modules\Blog\Models\BlogTagModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class BlogAdminApiController extends ResourceController
{
    protected $postModel;
    protected $categoryModel;
    protected $tagModel;
    protected $format = 'json';

    public function __construct()
    {
        $this->postModel = new BlogPostModel();
        $this->categoryModel = new BlogCategoryModel();
        $this->tagModel = new BlogTagModel();
    }

    /**
     * Check if user is authenticated
     */
    protected function checkAuth(): bool
    {
        $user = service('auth')->user();
        
        if (!$user) {
            return false;
        }
        
        // Check for blog permissions
        if (!service('auth')->getPermission('blog.manage') && 
            !service('auth')->getPermission('blog.create')) {
            return false;
        }
        
        return true;
    }

    /**
     * GET /api/admin/blog/posts
     * List all posts (including drafts)
     */
    public function posts()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $page = (int) ($this->request->getGet('page') ?? 1);
        $limit = (int) ($this->request->getGet('limit') ?? 20);
        
        $posts = $this->postModel->getAllPosts($page, $limit);
        
        return $this->respond([
            'success' => true,
            'data' => $posts,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $this->postModel->pager->getPageCount(),
                'total_items' => $this->postModel->pager->getTotal()
            ]
        ]);
    }

    /**
     * POST /api/admin/blog/posts
     * Create new post
     */
    public function createPost()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        // Validation
        if (empty($data['title']) || empty($data['content'])) {
            return $this->failValidationError([
                'success' => false,
                'message' => 'Title and content are required',
                'errors' => [
                    'title' => empty($data['title']) ? 'Title is required' : '',
                    'content' => empty($data['content']) ? 'Content is required' : ''
                ]
            ]);
        }

        $user = service('auth')->user();
        
        $postData = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? '',
            'content' => $data['content'],
            'excerpt' => $data['excerpt'] ?? '',
            'featured_image' => $data['featured_image'] ?? '',
            'author_id' => $user->id,
            'category_id' => $data['category_id'] ?? null,
            'meta_title' => $data['meta_title'] ?? '',
            'meta_description' => $data['meta_description'] ?? '',
            'meta_keywords' => $data['meta_keywords'] ?? '',
            'is_published' => $data['is_published'] ?? 0,
            'is_featured' => $data['is_featured'] ?? 0,
            'published_at' => $data['published_at'] ?? null,
        ];

        // Process tags
        if (!empty($data['tags'])) {
            $postData['tags'] = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
        }

        try {
            $postId = $this->postModel->createPost($postData);
            
            return $this->respondCreated([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => ['id' => $postId]
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to create post: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * GET /api/admin/blog/posts/:id
     * Get post by ID
     */
    public function post(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $post = $this->postModel->find($id);
        
        if (!$post) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Post not found'
            ]);
        }

        // Get tags
        $post['tags'] = $this->postModel->getPostTags($id);
        
        return $this->respond([
            'success' => true,
            'data' => $post
        ]);
    }

    /**
     * PUT /api/admin/blog/posts/:id
     * Update post
     */
    public function updatePost(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $post = $this->postModel->find($id);
        
        if (!$post) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Post not found'
            ]);
        }

        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        // Validation
        if (empty($data['title']) || empty($data['content'])) {
            return $this->failValidationError([
                'success' => false,
                'message' => 'Title and content are required'
            ]);
        }

        $postData = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? '',
            'content' => $data['content'],
            'excerpt' => $data['excerpt'] ?? '',
            'featured_image' => $data['featured_image'] ?? '',
            'category_id' => $data['category_id'] ?? null,
            'meta_title' => $data['meta_title'] ?? '',
            'meta_description' => $data['meta_description'] ?? '',
            'meta_keywords' => $data['meta_keywords'] ?? '',
            'is_published' => $data['is_published'] ?? 0,
            'is_featured' => $data['is_featured'] ?? 0,
            'published_at' => $data['published_at'] ?? null,
        ];

        // Process tags
        if (isset($data['tags'])) {
            $postData['tags'] = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
        }

        try {
            $this->postModel->updatePost($id, $postData);
            
            return $this->respond([
                'success' => true,
                'message' => 'Post updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to update post: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * DELETE /api/admin/blog/posts/:id
     * Delete post
     */
    public function deletePost(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $post = $this->postModel->find($id);
        
        if (!$post) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Post not found'
            ]);
        }

        try {
            $this->postModel->delete($id);
            
            return $this->respondDeleted([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to delete post: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * POST /api/admin/blog/posts/:id/toggle
     * Toggle publish status
     */
    public function togglePost(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $post = $this->postModel->find($id);
        
        if (!$post) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Post not found'
            ]);
        }

        $newStatus = $post['is_published'] ? 0 : 1;
        
        $this->postModel->update($id, [
            'is_published' => $newStatus,
            'published_at' => $newStatus ? date('Y-m-d H:i:s') : null,
        ]);

        return $this->respond([
            'success' => true,
            'message' => $newStatus ? 'Post published' : 'Post unpublished',
            'data' => ['is_published' => $newStatus]
        ]);
    }

    /**
     * POST /api/admin/blog/posts/:id/feature
     * Toggle featured status
     */
    public function featurePost(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $post = $this->postModel->find($id);
        
        if (!$post) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Post not found'
            ]);
        }

        $newStatus = $post['is_featured'] ? 0 : 1;
        
        $this->postModel->update($id, ['is_featured' => $newStatus]);

        return $this->respond([
            'success' => true,
            'message' => $newStatus ? 'Post featured' : 'Post unfeatured',
            'data' => ['is_featured' => $newStatus]
        ]);
    }

    /**
     * GET /api/admin/blog/categories
     * List categories
     */
    public function categories()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $categories = $this->categoryModel->getAllCategoriesAdmin();
        
        return $this->respond([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * POST /api/admin/blog/categories
     * Create category
     */
    public function createCategory()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (empty($data['name'])) {
            return $this->failValidationError([
                'success' => false,
                'message' => 'Category name is required'
            ]);
        }

        try {
            $categoryId = $this->categoryModel->createCategory([
                'name' => $data['name'],
                'slug' => $data['slug'] ?? '',
                'description' => $data['description'] ?? '',
                'image' => $data['image'] ?? '',
                'parent_id' => $data['parent_id'] ?? null,
                'display_order' => $data['display_order'] ?? 0,
                'is_active' => $data['is_active'] ?? 1,
            ]);
            
            return $this->respondCreated([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => ['id' => $categoryId]
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to create category: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * PUT /api/admin/blog/categories/:id
     * Update category
     */
    public function updateCategory(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }

        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        try {
            $this->categoryModel->updateCategory($id, $data);
            
            return $this->respond([
                'success' => true,
                'message' => 'Category updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to update category: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * DELETE /api/admin/blog/categories/:id
     * Delete category
     */
    public function deleteCategory(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }

        try {
            $this->categoryModel->delete($id);
            
            return $this->respondDeleted([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * GET /api/admin/blog/tags
     * List tags
     */
    public function tags()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $tags = $this->tagModel->getTagsWithPostCount();
        
        return $this->respond([
            'success' => true,
            'data' => $tags
        ]);
    }

    /**
     * POST /api/admin/blog/tags
     * Create tag
     */
    public function createTag()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $name = $this->request->getPost('name');
        
        if (empty($name)) {
            return $this->failValidationError([
                'success' => false,
                'message' => 'Tag name is required'
            ]);
        }

        try {
            $tagId = $this->tagModel->createTag($name);
            
            return $this->respondCreated([
                'success' => true,
                'message' => 'Tag created successfully',
                'data' => ['id' => $tagId]
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to create tag: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * DELETE /api/admin/blog/tags/:id
     * Delete tag
     */
    public function deleteTag(int $id)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $tag = $this->tagModel->find($id);
        
        if (!$tag) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Tag not found'
            ]);
        }

        try {
            $this->tagModel->delete($id);
            
            return $this->respondDeleted([
                'success' => true,
                'message' => 'Tag deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError([
                'success' => false,
                'message' => 'Failed to delete tag: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * POST /api/admin/blog/ai/generate-summary
     * AI generate summary
     */
    public function generateSummary()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $content = $this->request->getPost('content');
        
        if (empty($content)) {
            return $this->failValidationError([
                'success' => false,
                'message' => 'Content is required'
            ]);
        }

        // Placeholder for AI integration
        $summary = $this->generatePlaceholderSummary($content);
        
        return $this->respond([
            'success' => true,
            'data' => ['summary' => $summary]
        ]);
    }

    /**
     * POST /api/admin/blog/ai/extract-keywords
     * AI extract keywords
     */
    public function extractKeywords()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $content = $this->request->getPost('content');
        
        if (empty($content)) {
            return $this->failValidationError([
                'success' => false,
                'message' => 'Content is required'
            ]);
        }

        // Placeholder for AI integration
        $keywords = $this->extractPlaceholderKeywords($content);
        
        return $this->respond([
            'success' => true,
            'data' => ['keywords' => implode(', ', $keywords)]
        ]);
    }

    /**
     * GET /api/admin/blog/stats
     * Get blog statistics
     */
    public function stats()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $stats = $this->postModel->getStats();
        
        return $this->respond([
            'success' => true,
            'data' => $stats
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
        
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 
            'of', 'with', 'by', 'from', 'as', 'is', 'was', 'are', 'were', 'been', 'be',
            'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should'];
        
        preg_match_all('/\b[a-z]{3,}\b/', $text, $words);
        
        $wordCounts = array_count_values($words[0]);
        
        foreach ($stopWords as $stop) {
            unset($wordCounts[$stop]);
        }
        
        arsort($wordCounts);
        
        return array_slice(array_keys($wordCounts), 0, 10);
    }
}

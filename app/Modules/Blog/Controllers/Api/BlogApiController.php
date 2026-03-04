<?php

/**
 * Blog API Controller
 * 
 * Handles public API endpoints for the blog module.
 * These endpoints are accessible without authentication.
 */

namespace Modules\Blog\Controllers\Api;

use Modules\Blog\Models\BlogPostModel;
use Modules\Blog\Models\BlogCategoryModel;
use Modules\Blog\Models\BlogTagModel;
use CodeIgniter\RESTful\ResourceController;

class BlogApiController extends ResourceController
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
     * GET /api/blog/posts
     * List published posts with pagination
     */
    public function posts()
    {
        $page = (int) ($this->request->getGet('page') ?? 1);
        $limit = (int) ($this->request->getGet('limit') ?? config('Blog')->apiDefaultLimit ?? 10);
        
        // Validate limit
        $maxLimit = config('Blog')->apiMaxLimit ?? 100;
        $limit = min($limit, $maxLimit);
        
        $posts = $this->postModel->getPublishedPosts($page, $limit);
        $pager = $this->postModel->pager;
        
        return $this->respond([
            'success' => true,
            'data' => [
                'posts' => $posts,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $pager->getPageCount(),
                    'total_items' => $pager->getTotal(),
                    'per_page' => $limit,
                    'has_more' => $page < $pager->getPageCount()
                ]
            ]
        ]);
    }

    /**
     * GET /api/blog/posts/:slug
     * Get single post by slug
     */
    public function post(string $slug)
    {
        $post = $this->postModel->getPostBySlug($slug);
        
        if (!$post) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Blog post not found'
            ]);
        }

        // Increment view count
        $this->postModel->incrementViewCount($post['id']);
        
        // Get tags
        $post['tags'] = $this->postModel->getPostTags($post['id']);
        
        return $this->respond([
            'success' => true,
            'data' => $post
        ]);
    }

    /**
     * GET /api/blog/posts/featured
     * Get featured posts
     */
    public function featured()
    {
        $limit = (int) ($this->request->getGet('limit') ?? 5);
        
        $posts = $this->postModel->getFeaturedPosts($limit);
        
        return $this->respond([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * GET /api/blog/categories
     * List all categories
     */
    public function categories()
    {
        $categories = $this->categoryModel->getCategoriesWithPostCount();
        
        return $this->respond([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * GET /api/blog/categories/:slug
     * Get category by slug with posts
     */
    public function category(string $slug)
    {
        $category = $this->categoryModel->getCategoryBySlug($slug);
        
        if (!$category) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }

        $page = (int) ($this->request->getGet('page') ?? 1);
        $limit = (int) ($this->request->getGet('limit') ?? 10);
        
        $posts = $this->postModel->getPostsByCategory($slug, $page, $limit);
        
        // Get post count
        $postCount = $this->postModel->where('category_id', $category['id'])
            ->published()
            ->countAllResults();
        
        return $this->respond([
            'success' => true,
            'data' => [
                'category' => $category,
                'posts' => $posts,
                'post_count' => $postCount,
                'pagination' => [
                    'current_page' => $page,
                    'total_items' => $postCount,
                    'per_page' => $limit
                ]
            ]
        ]);
    }

    /**
     * GET /api/blog/tags
     * List all tags
     */
    public function tags()
    {
        $tags = $this->tagModel->getTagsWithPostCount();
        
        return $this->respond([
            'success' => true,
            'data' => $tags
        ]);
    }

    /**
     * GET /api/blog/tags/:slug
     * Get tag by slug with posts
     */
    public function tag(string $slug)
    {
        $tag = $this->tagModel->getTagBySlug($slug);
        
        if (!$tag) {
            return $this->failNotFound([
                'success' => false,
                'message' => 'Tag not found'
            ]);
        }

        $page = (int) ($this->request->getGet('page') ?? 1);
        $limit = (int) ($this->request->getGet('limit') ?? 10);
        
        $posts = $this->postModel->getPostsByTag($slug, $page, $limit);
        
        // Get post count
        $db = \Config\Database::connect();
        $postCount = $db->table('blog_post_tags')
            ->where('tag_id', $tag['id'])
            ->join('blog_posts', 'blog_posts.id = blog_post_tags.post_id')
            ->where('blog_posts.is_published', 1)
            ->where('blog_posts.published_at <=', date('Y-m-d H:i:s'))
            ->countAllResults();
        
        return $this->respond([
            'success' => true,
            'data' => [
                'tag' => $tag,
                'posts' => $posts,
                'post_count' => $postCount,
                'pagination' => [
                    'current_page' => $page,
                    'total_items' => $postCount,
                    'per_page' => $limit
                ]
            ]
        ]);
    }

    /**
     * GET /api/blog/search
     * Search posts
     */
    public function search()
    {
        $keyword = $this->request->getGet('q') ?? '';
        
        if (empty($keyword)) {
            return $this->respond([
                'success' => true,
                'data' => [
                    'posts' => [],
                    'keyword' => '',
                    'message' => 'Please provide a search keyword'
                ]
            ]);
        }

        $page = (int) ($this->request->getGet('page') ?? 1);
        $limit = (int) ($this->request->getGet('limit') ?? 10);
        
        $posts = $this->postModel->searchPosts($keyword, $page, $limit);
        $pager = $this->postModel->pager;
        
        return $this->respond([
            'success' => true,
            'data' => [
                'posts' => $posts,
                'keyword' => $keyword,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $pager->getPageCount(),
                    'total_items' => $pager->getTotal(),
                    'per_page' => $limit
                ]
            ]
        ]);
    }

    /**
     * GET /api/blog/sitemap
     * Get sitemap data
     */
    public function sitemap()
    {
        $posts = $this->postModel->published()
            ->orderBy('updated_at', 'DESC')
            ->find();
        
        $categories = $this->categoryModel->active()->find();
        
        return $this->respond([
            'success' => true,
            'data' => [
                'posts' => $posts,
                'categories' => $categories,
                'base_url' => base_url('blog')
            ]
        ]);
    }
}

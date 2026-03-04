<?php

/**
 * Blog Tag Model
 * 
 * Handles all database operations for blog tags.
 */

namespace Modules\Blog\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class BlogTagModel extends Model
{
    protected $table            = 'blog_tags';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    
    protected $allowedFields = [
        'name',
        'slug',
        'created_at'
    ];

    protected array $casts = [
        'id' => 'int',
    ];

    protected $dates = ['created_at'];
    
    // Validation rules
    protected $validationRules = [
        'name' => 'required|max_length[50]|is_unique[blog_tags.name]',
        'slug' => 'required|max_length[50]|alpha_dash|is_unique[blog_tags.slug]',
    ];

    /**
     * Initialize model
     */
    public function initialize()
    {
        parent::initialize();
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get posts with this tag
     */
    public function posts()
    {
        return $this->belongsToMany(
            'Modules\Blog\Models\BlogPostModel',
            'blog_post_tags',
            'tag_id',
            'post_id'
        );
    }

    // ==========================================
    // CRUD OPERATIONS
    // ==========================================

    /**
     * Get all tags
     */
    public function getAllTags()
    {
        return $this->orderBy('name', 'ASC')->find();
    }

    /**
     * Get tag by slug
     */
    public function getTagBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Get tag by name
     */
    public function getTagByName(string $name)
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get tags with post count
     */
    public function getTagsWithPostCount()
    {
        $db = \Config\Database::connect();
        
        $tags = $this->orderBy('name', 'ASC')->find();
        
        foreach ($tags as &$tag) {
            $count = $db->table('blog_post_tags')
                ->where('tag_id', $tag['id'])
                ->join('blog_posts', 'blog_posts.id = blog_post_tags.post_id')
                ->where('blog_posts.is_published', 1)
                ->where('blog_posts.published_at <=', date('Y-m-d H:i:s'))
                ->countAllResults();
            
            $tag['post_count'] = $count;
        }
        
        return $tags;
    }

    /**
     * Get popular tags (tags with most posts)
     */
    public function getPopularTags(int $limit = 10)
    {
        $db = \Config\Database::connect();
        
        $tags = $db->table('blog_tags')
            ->select('blog_tags.*, COUNT(blog_post_tags.post_id) as post_count')
            ->join('blog_post_tags', 'blog_post_tags.tag_id = blog_tags.id')
            ->join('blog_posts', 'blog_posts.id = blog_post_tags.post_id AND blog_posts.is_published = 1 AND blog_posts.published_at <= NOW()')
            ->groupBy('blog_tags.id')
            ->orderBy('post_count', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
        
        return $tags;
    }

    // ==========================================
    // SLUG GENERATION
    // ==========================================

    /**
     * Generate unique slug from name
     */
    public function generateSlug(string $name): string
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->where('slug', $slug)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // ==========================================
    // CREATE/UPDATE HELPERS
    // ==========================================

    /**
     * Create a new tag
     */
    public function createTag(string $name): int
    {
        // Check if tag already exists
        $existing = $this->getTagByName($name);
        if ($existing) {
            return $existing['id'];
        }

        $data = [
            'name' => $name,
            'slug' => $this->generateSlug($name),
            'created_at' => Time::now()->toDateTimeString(),
        ];

        return $this->insert($data);
    }

    /**
     * Create tags from array of names
     */
    public function createTagsFromArray(array $names): array
    {
        $tagIds = [];
        
        foreach ($names as $name) {
            $name = trim($name);
            if (!empty($name)) {
                $tagIds[] = $this->createTag($name);
            }
        }
        
        return $tagIds;
    }

    /**
     * Get or create tag
     */
    public function getOrCreate(string $name): int
    {
        $tag = $this->getTagByName($name);
        
        if ($tag) {
            return $tag['id'];
        }
        
        return $this->createTag($name);
    }
}

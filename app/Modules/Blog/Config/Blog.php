<?php

/**
 * Blog Module Configuration
 * 
 * Contains all configurable settings for the Blog module including:
 * - Pagination settings
 * - SEO configuration
 * - Content settings
 * - AI feature toggles
 */

namespace Modules\Blog\Config;

use CodeIgniter\Config\BaseConfig;

class Blog extends BaseConfig
{
    // ==========================================
    // PAGINATION SETTINGS
    // ==========================================
    
    /**
     * Number of posts to display per page
     */
    public int $postsPerPage = 12;
    
    /**
     * Number of related posts to display
     */
    public int $relatedPostsCount = 3;
    
    /**
     * Number of recent posts to show in footer/sidebar
     */
    public int $recentPostsCount = 5;
    
    /**
     * Number of popular posts to display
     */
    public int $popularPostsCount = 5;

    // ==========================================
    // SEO SETTINGS
    // ==========================================
    
    /**
     * Maximum length for meta title (Google recommends 50-60)
     */
    public int $metaTitleMaxLength = 70;
    
    /**
     * Maximum length for meta description (Google recommends 150-160)
     */
    public int $metaDescriptionMaxLength = 160;
    
    /**
     * Maximum length for meta keywords
     */
    public int $metaKeywordsMaxLength = 255;
    
    /**
     * Auto-generate URL-friendly slug from title
     */
    public bool $autoGenerateSlug = true;
    
    /**
     * Generate XML sitemap automatically
     */
    public bool $generateSitemap = true;
    
    /**
     * Include blog in main sitemap
     */
    public bool $includeInMainSitemap = true;
    
    /**
     * Default sitemap priority for posts (0.0 - 1.0)
     */
    public float $sitemapDefaultPriority = 0.7;
    
    /**
     * Sitemap change frequency
     */
    public string $sitemapChangeFreq = 'weekly';

    // ==========================================
    // CONTENT SETTINGS
    // ==========================================
    
    /**
     * Enable automatic reading time calculation
     */
    public bool $enableReadingTime = true;
    
    /**
     * Average reading speed (words per minute)
     */
    public int $wordsPerMinute = 200;
    
    /**
     * Enable AI features
     */
    public bool $enableAI = true;
    
    /**
     * Auto-generate excerpt from content if not provided
     */
    public bool $autoGenerateExcerpt = true;
    
    /**
     * Excerpt length (number of words)
     */
    public int $excerptLength = 55;
    
    /**
     * Enable featured image
     */
    public bool $enableFeaturedImage = true;
    
    /**
     * Allowed image extensions
     */
    public array $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    /**
     * Maximum image size in bytes (default 2MB)
     */
    public int $maxImageSize = 2097152;

    // ==========================================
    // PUBLIC FEATURES
    // ==========================================
    
    /**
     * Enable comments (future feature)
     */
    public bool $enableComments = false;
    
    /**
     * Enable RSS/Atom feed
     */
    public bool $enableRSSFeed = true;
    
    /**
     * Enable search functionality
     */
    public bool $enableSearch = true;
    
    /**
     * Enable category filtering
     */
    public bool $enableCategories = true;
    
    /**
     * Enable tag filtering
     */
    public bool $enableTags = true;
    
    /**
     * Enable featured posts section
     */
    public bool $enableFeaturedPosts = true;
    
    /**
     * Number of posts to show in featured carousel
     */
    public int $featuredPostsCount = 5;

    // ==========================================
    // PERMALINK SETTINGS
    // ==========================================
    
    /**
     * URL structure for blog posts
     * Options: slug, category/slug, blog/slug
     */
    public string $permalinkStructure = 'blog';
    
    /**
     * URL structure for categories
     */
    public string $categoryStructure = 'blog/category';
    
    /**
     * URL structure for tags
     */
    public string $tagStructure = 'blog/tag';

    // ==========================================
    // CACHE SETTINGS
    // ==========================================
    
    /**
     * Enable caching for blog pages
     */
    public bool $enableCaching = true;
    
    /**
     * Cache duration in seconds (default 1 hour)
     */
    public int $cacheDuration = 3600;

    // ==========================================
    // API SETTINGS
    // ==========================================
    
    /**
     * Enable public API
     */
    public bool $enablePublicAPI = true;
    
    /**
     * Enable admin API
     */
    public bool $enableAdminAPI = true;
    
    /**
     * API rate limit (requests per minute)
     */
    public int $apiRateLimit = 60;
    
    /**
     * Default number of posts per API request
     */
    public int $apiDefaultLimit = 10;
    
    /**
     * Maximum number of posts per API request
     */
    public int $apiMaxLimit = 100;

    // ==========================================
    // ADMIN SETTINGS
    // ==========================================
    
    /**
     * Default post status on creation
     */
    public bool $defaultPostStatus = false;
    
    /**
     * Enable post preview before publishing
     */
    public bool $enablePreview = true;
    
    /**
     * Enable draft saving
     */
    public bool $enableDrafts = true;
    
    /**
     * Number of drafts to keep
     */
    public int $maxDrafts = 5;

    // ==========================================
    // MAINTENANCE SETTINGS
    // ==========================================
    
    /**
     * Enable blog (set to false for maintenance)
     */
    public bool $blogEnabled = true;
    
    /**
     * Message to show when blog is disabled
     */
    public string $maintenanceMessage = 'The blog is currently under maintenance.';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PageviewModel extends Model
{
    protected $table            = 'pageviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['page_url', 'page_name', 'view_count', 'visitor_ip', 'visitor_country', 'visitor_city', 'last_viewed_at', 'created_at', 'updated_at'];
    protected $useTimestamps      = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Record a page view - increments the view count or creates new record
     * Also records visitor IP and location
     *
     * @param string $pageUrl The URL of the page
     * @param string|null $pageName Optional human-readable name for the page
     * @param string|null $visitorIp Visitor's IP address
     * @param string|null $country Visitor's country
     * @param string|null $city Visitor's city
     * @return array View count and unique visitor count
     */
    public function recordPageView(string $pageUrl, ?string $pageName = null, ?string $visitorIp = null, ?string $country = null, ?string $city = null): array
    {
        // Normalize the URL
        $normalizedUrl = strtolower(trim($pageUrl));
        
        // Track unique visitor
        $isUnique = $this->trackUniqueVisitor($normalizedUrl, $visitorIp);

        // Check if record exists
        $existing = $this->where('page_url', $normalizedUrl)->first();

        if ($existing) {
            // Increment view count
            $newCount = $existing['view_count'] + 1;
            
            // Increment unique count if new visitor
            $uniqueCount = ($existing['unique_visitor_count'] ?? 0) + ($isUnique ? 1 : 0);
            
            $this->update($existing['id'], [
                'view_count'       => $newCount,
                'unique_visitor_count' => $uniqueCount,
                'last_viewed_at'   => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);
            return ['views' => $newCount, 'unique' => $uniqueCount];
        } else {
            // Create new record
            $this->insert([
                'page_url'          => $normalizedUrl,
                'page_name'         => $pageName ?? basename($pageUrl),
                'view_count'        => 1,
                'unique_visitor_count' => $isUnique ? 1 : 0,
                'visitor_ip'        => $visitorIp,
                'visitor_country'   => $country,
                'visitor_city'      => $city,
                'last_viewed_at'    => date('Y-m-d H:i:s'),
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
            return ['views' => 1, 'unique' => $isUnique ? 1 : 0];
        }
    }
    
    /**
     * Track unique visitor by IP for a specific page
     * 
     * @param string $pageUrl The normalized URL
     * @param string|null $visitorIp Visitor's IP
     * @return bool True if this is a new unique visitor
     */
    protected function trackUniqueVisitor(string $pageUrl, ?string $visitorIp): bool
    {
        if (empty($visitorIp)) {
            return false;
        }
        
        $db = \Config\Database::connect();
        
        // Check if this IP already visited this page today
        $today = date('Y-m-d');
        $builder = $db->table('pageview_visitors');
        $existing = $builder->where('page_url', $pageUrl)
                           ->where('visitor_ip', $visitorIp)
                           ->where('DATE(visited_at)', $today)
                           ->get()
                           ->getRow();
        
        if ($existing) {
            // Update visited time
            $builder->where('id', $existing->id)
                   ->update(['visited_at' => date('Y-m-d H:i:s')]);
            return false; // Not a new unique visitor
        }
        
        // Insert new unique visitor
        try {
            $builder->insert([
                'page_url'   => $pageUrl,
                'visitor_ip' => $visitorIp,
                'visited_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            // If insert fails (duplicate key), just return false
            return false;
        }
        
        return true; // New unique visitor
    }

    /**
     * Get view count and unique visitor count for a specific page
     *
     * @param string $pageUrl The URL of the page
     * @return array View count and unique visitor count
     */
    public function getPageViewCount(string $pageUrl): array
    {
        $normalizedUrl = strtolower(trim($pageUrl));
        $page = $this->where('page_url', $normalizedUrl)->first();

        if ($page) {
            return [
                'views' => (int) $page['view_count'],
                'unique' => (int) ($page['unique_visitor_count'] ?? 0)
            ];
        }
        return ['views' => 0, 'unique' => 0];
    }

    /**
     * Get all pageviews ordered by view count
     *
     * @param int $limit Number of records to return
     * @return array
     */
    public function getTopPages(int $limit = 10): array
    {
        return $this->orderBy('view_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}

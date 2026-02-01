<?php

if (!function_exists('render_menu')) {
    /**
     * Render menu items as HTML
     * 
     * @param array $menuItems Array of menu items
     * @param string $currentUrl Current URL for active state
     * @return string HTML output
     */
    function render_menu(array $menuItems, string $currentUrl = ''): string
    {
        if (empty($menuItems)) {
            return '';
        }
        
        $html = '<ul class="nav flex-column">';
        
        foreach ($menuItems as $item) {
            $active = is_active_menu($item['url']) ? 'active' : '';
            $icon = $item['icon'] ?? 'circle';
            
            $html .= '<li class="nav-item">';
            $html .= '<a class="nav-link ' . $active . '" href="' . base_url($item['url']) . '">';
            $html .= '<i class="bi bi-' . esc($icon) . '"></i>';
            $html .= '<span>' . esc($item['title']) . '</span>';
            $html .= '</a>';
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }
}

if (!function_exists('is_active_menu')) {
    /**
     * Check if menu item is active based on current URL
     * 
     * @param string $menuUrl Menu item URL
     * @return bool
     */
    function is_active_menu(string $menuUrl): bool
    {
        $currentUrl = uri_string();
        
        // Exact match
        if ($currentUrl === trim($menuUrl, '/')) {
            return true;
        }
        
        // Check if current URL starts with menu URL (for sub-pages)
        if (!empty($menuUrl) && str_starts_with($currentUrl, trim($menuUrl, '/'))) {
            return true;
        }
        
        return false;
    }
}

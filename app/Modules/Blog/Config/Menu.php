<?php

/**
 * Blog Module Menu Configuration
 * 
 * Defines the admin menu items for the Blog module.
 * This configuration is used to generate the admin navigation.
 */

return [
    [
        'title' => 'Blog',
        'url' => 'admin/blog',
        'icon' => 'bi-journal-text',
        'permission' => 'blog.manage',
        'order' => 5,
        'category' => 'content'
    ],
    [
        'title' => 'Blog Posts',
        'url' => 'admin/blog',
        'icon' => 'bi-file-post',
        'permission' => 'blog.manage',
        'order' => 6,
        'category' => 'content'
    ],
    [
        'title' => 'Categories',
        'url' => 'admin/blog/categories',
        'icon' => 'bi-folder',
        'permission' => 'blog.categories.manage',
        'order' => 7,
        'category' => 'content'
    ],
    [
        'title' => 'Tags',
        'url' => 'admin/blog/tags',
        'icon' => 'bi-tags',
        'permission' => 'blog.tags.manage',
        'order' => 8,
        'category' => 'content'
    ]
];

<?php

/**
 * Menu configuration for Settings module
 */

return [
    [
        'title' => 'Settings',
        'url' => 'settings',
        'icon' => 'gear',
        'permission' => 'admin.settings',
        'order' => 3,
        'category' => 'administration'
    ],
    [
        'title' => 'Terms & Conditions',
        'url' => 'settings/terms',
        'icon' => 'file-text',
        'permission' => 'admin.settings',
        'order' => 4,
        'category' => 'administration'
    ]
];

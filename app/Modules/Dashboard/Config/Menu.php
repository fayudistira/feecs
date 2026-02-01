<?php

/**
 * Menu configuration for Dashboard module
 * This file registers menu items that will appear in the dashboard sidebar
 */

return [
    [
        'title' => 'Dashboard',
        'url' => 'dashboard',
        'icon' => 'speedometer2',
        'permission' => 'dashboard.access',
        'order' => 1
    ]
];

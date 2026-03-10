<?php

/**
 * Menu configuration for Test module
 * This file registers menu items that will appear in the dashboard sidebar
 */

return [
    [
        'title' => 'HSK Registrations',
        'url' => 'test/hsk-registrations',
        'icon' => 'bi bi-file-earmark-text',
        'permission' => 'test.view',
        'order' => 150
    ]
];

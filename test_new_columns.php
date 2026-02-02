<?php
// Test new mode and curriculum columns
require __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
$pathsConfig = new Config\Paths();
require_once SYSTEMPATH . 'Boot.php';
boot_app(APPPATH, ROOTPATH);

$programModel = new \Modules\Program\Models\ProgramModel();

echo "Testing new columns...\n\n";

// Get first program
$program = $programModel->first();

if ($program) {
    echo "Program: " . $program['title'] . "\n";
    echo "Mode: " . ($program['mode'] ?? 'NOT SET') . "\n";
    echo "Curriculum: " . (isset($program['curriculum']) ? (is_array($program['curriculum']) ? 'Array (' . count($program['curriculum']) . ' items)' : 'String') : 'NOT SET') . "\n";
    
    // Test update with new fields
    echo "\nTesting update...\n";
    $result = $programModel->update($program['id'], [
        'mode' => 'online',
        'curriculum' => [
            [
                'chapter' => 'Chapter 1: Introduction',
                'description' => 'Getting started with the program'
            ],
            [
                'chapter' => 'Chapter 2: Core Concepts',
                'description' => 'Understanding the fundamentals'
            ]
        ]
    ]);
    
    if ($result) {
        echo "✓ Update successful!\n";
        
        // Fetch again to verify
        $updated = $programModel->find($program['id']);
        echo "Updated Mode: " . $updated['mode'] . "\n";
        echo "Updated Curriculum: " . count($updated['curriculum']) . " chapters\n";
        
        foreach ($updated['curriculum'] as $chapter) {
            echo "  - " . $chapter['chapter'] . "\n";
        }
    } else {
        echo "✗ Update failed\n";
    }
} else {
    echo "No programs found\n";
}

echo "\n✓ Test complete!\n";

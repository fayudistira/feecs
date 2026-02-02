<?php
// Update existing programs with default mode value
require __DIR__ . '/vendor/autoload.php';

// Define paths
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('APPPATH', ROOTPATH . 'app' . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', ROOTPATH . 'vendor/codeigniter4/framework/system' . DIRECTORY_SEPARATOR);
define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);
define('WRITEPATH', ROOTPATH . 'writable' . DIRECTORY_SEPARATOR);

// Bootstrap CodeIgniter
require_once SYSTEMPATH . 'Boot.php';
$app = \CodeIgniter\Boot::bootWeb(new \Config\Paths());

$programModel = new \Modules\Program\Models\ProgramModel();

echo "Updating existing programs with default mode...\n\n";

// Get all programs
$programs = $programModel->findAll();

if (empty($programs)) {
    echo "No programs found.\n";
    exit;
}

$updated = 0;
$skipped = 0;

foreach ($programs as $program) {
    // Check if mode is already set
    if (!empty($program['mode'])) {
        echo "Program '{$program['title']}' already has mode: {$program['mode']} - Skipped\n";
        $skipped++;
        continue;
    }
    
    // Update with default mode
    $result = $programModel->update($program['id'], [
        'mode' => 'offline'
    ]);
    
    if ($result) {
        echo "✓ Updated '{$program['title']}' - Set mode to 'offline'\n";
        $updated++;
    } else {
        echo "✗ Failed to update '{$program['title']}'\n";
    }
}

echo "\n";
echo "Summary:\n";
echo "- Updated: $updated programs\n";
echo "- Skipped: $skipped programs\n";
echo "- Total: " . count($programs) . " programs\n";
echo "\n✓ Update complete!\n";

<?php
$dirs = [
    'storage/framework/cache',
    'storage/framework/sessions',
    'bootstrap/cache'
];

echo "=== Clearing Laravel Cache ===\n\n";

foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✓ Cleared: $dir\n";
    }
}

echo "\n✓ Cache cleared successfully!\n";
echo "Please reload the register page now.\n";
?>

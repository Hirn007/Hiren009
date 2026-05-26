<?php
// Create products directory if it doesn't exist
$productsDir = 'storage/app/public/products';
if (!is_dir($productsDir)) {
    mkdir($productsDir, 0777, true);
}

// Copy all files from uplode/products to products
$uplodeDir = 'storage/app/public/uplode/products';
$files = glob($uplodeDir . '/*');

foreach ($files as $file) {
    if (is_file($file)) {
        $filename = basename($file);
        $destination = $productsDir . '/' . $filename;
        if (copy($file, $destination)) {
            echo "Copied: $filename\n";
        } else {
            echo "Failed to copy: $filename\n";
        }
    }
}

// Verify files in destination
echo "\n=== Files in products directory ===\n";
$files = glob($productsDir . '/*');
foreach ($files as $file) {
    if (is_file($file)) {
        echo basename($file) . " (" . filesize($file) . " bytes)\n";
    }
}

echo "\nDone!\n";
?>

<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

try {
    // Get all products with images
    $products = \App\Models\Product::whereNotNull('image')->get();
    
    echo "=== Updating Product Image Paths ===\n\n";
    
    foreach ($products as $product) {
        $oldPath = $product->image;
        
        // Convert uplode/products/ to products/
        if (strpos($oldPath, 'uplode/products/') !== false) {
            $newPath = str_replace('uplode/products/', 'products/', $oldPath);
            
            // Update the database
            $product->update(['image' => $newPath]);
            
            echo "ID {$product->id}: {$oldPath}\n  → {$newPath}\n";
        } elseif (strpos($oldPath, 'products/') === false) {
            // If it doesn't have products/ prefix, add it
            $filename = basename($oldPath);
            $newPath = 'products/' . $filename;
            
            $product->update(['image' => $newPath]);
            
            echo "ID {$product->id}: {$oldPath}\n  → {$newPath}\n";
        } else {
            echo "ID {$product->id}: Already correct - {$oldPath}\n";
        }
    }
    
    echo "\n=== Final Database State ===\n";
    $products = \App\Models\Product::whereNotNull('image')->get();
    foreach ($products as $product) {
        $fullUrl = asset('storage/' . $product->image);
        $fileExists = file_exists(public_path('storage/' . $product->image));
        echo "ID {$product->id}: {$product->name}\n  Path: {$product->image}\n  Exists: " . ($fileExists ? 'YES ✓' : 'NO ✗') . "\n\n";
    }
    
    echo "✓ All image paths have been updated successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

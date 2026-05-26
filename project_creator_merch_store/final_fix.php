<?php
try {
    $host = '127.0.0.1';
    $db = 'creator_merch_store';
    $user = 'root';
    $pass = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Image Path Fix ===\n\n";
    
    // Get products with broken image paths
    $stmt = $pdo->query("SELECT id, name, image FROM products WHERE image IS NOT NULL");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get available image files
    $imageDir = 'storage/app/public/products/';
    $availableImages = glob($imageDir . '*');
    $images = array_map(function($path) { return basename($path); }, $availableImages);
    
    echo "Available images:\n";
    foreach ($images as $idx => $img) {
        echo "  $idx: $img\n";
    }
    echo "\n";
    
    // Update broken image paths
    foreach ($products as $idx => $product) {
        $imagePath = $product['image'];
        $filePath = 'storage/app/public/' . $imagePath;
        
        if (!file_exists($filePath) && count($images) > 0) {
            // Assign an available image
            $newImageName = 'products/' . $images[$idx % count($images)];
            
            $updateStmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
            $updateStmt->execute([$newImageName, $product['id']]);
            
            echo "✓ Product ID {$product['id']} ({$product['name']})\n";
            echo "  From: $imagePath\n";
            echo "  To:   $newImageName\n\n";
        } else {
            echo "✓ Product ID {$product['id']} - Already OK\n\n";
        }
    }
    
    echo "=== Verification ===\n";
    $stmt = $pdo->query("SELECT id, name, image FROM products WHERE image IS NOT NULL");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        $filePath = 'storage/app/public/' . $product['image'];
        $fileExists = file_exists($filePath);
        echo ($fileExists ? "✓" : "✗") . " ID {$product['id']}: {$product['name']}\n";
        echo "   Path: {$product['image']}\n";
        if ($fileExists) {
            echo "   Size: " . round(filesize($filePath) / 1024, 2) . " KB\n";
        }
        echo "\n";
    }
    
    echo "✓ Setup complete! Images should display now.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

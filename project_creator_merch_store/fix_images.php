<?php
try {
    // Database connection
    $host = '127.0.0.1';
    $db = 'creator_merch_store';
    $user = 'root';
    $pass = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Current Product Image Paths ===\n\n";
    
    // Get current paths
    $stmt = $pdo->query("SELECT id, name, image FROM products WHERE image IS NOT NULL");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        $path = $product['image'];
        echo "ID {$product['id']}: {$product['name']}\n  Current Path: $path\n";
        
        if (strpos($path, 'uplode/products/') !== false) {
            // Update: replace uplode/products/ with products/
            $newPath = str_replace('uplode/products/', 'products/', $path);
            
            $updateStmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
            $updateStmt->execute([$newPath, $product['id']]);
            
            echo "  → Updated to: $newPath ✓\n\n";
        } else {
            echo "  → Already correct\n\n";
        }
    }
    
    echo "=== Verification ===\n";
    $stmt = $pdo->query("SELECT id, name, image FROM products WHERE image IS NOT NULL");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $successCount = 0;
    foreach ($products as $product) {
        $filePath = 'storage/app/public/' . $product['image'];
        $fileExists = file_exists($filePath);
        if ($fileExists) {
            echo "✓ ID {$product['id']}: {$product['image']} - File exists\n";
            $successCount++;
        } else {
            echo "✗ ID {$product['id']}: {$product['image']} - File NOT found\n";
        }
    }
    
    echo "\n✓ Successfully verified: $successCount/{$stmt->rowCount()} products\n";
    echo "\nYour images should now display correctly!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

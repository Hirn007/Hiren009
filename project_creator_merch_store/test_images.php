<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

try {
    $products = \App\Models\Product::all();
    echo "==== Products in Database ====\n";
    foreach ($products as $p) {
        $imagePath = 'storage/' . $p->image;
        $fileExists = file_exists(public_path($imagePath));
        echo "ID: {$p->id} | Name: {$p->name} | Image DB: {$p->image} | File Exists: " . ($fileExists ? 'YES' : 'NO') . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

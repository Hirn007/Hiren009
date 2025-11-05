<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .product-list {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .product-item {
            background-color: #e9f5ff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .product-item:hover {
            background-color: #d0e8ff;
        }

        .product-title {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
        }

        .product-desc {
            color: #555;
            font-size: 0.95em;
        }
    </style>
</head>
<body>

    <h1>Our Latest Products</h1>

    <div class="product-list">
        <?php
        // Step 1: Create an array of products
        $products = [
            ["name" => "Wireless Headphones", "description" => "High-quality sound with noise cancellation."],
            ["name" => "Smart Watch", "description" => "Track your fitness and stay connected on the go."],
            ["name" => "Gaming Mouse", "description" => "Precision and speed for your best gaming experience."],
            ["name" => "Bluetooth Speaker", "description" => "Portable speaker with deep bass and clear sound."],
            ["name" => "USB-C Charger", "description" => "Fast charging compatible with all modern devices."]
        ];

        // Step 2: Use a loop to generate dynamic HTML
        foreach ($products as $item) {
            echo "<div class='product-item'>";
            echo "<div class='product-title'>" . htmlspecialchars($item['name']) . "</div>";
            echo "<div class='product-desc'>" . htmlspecialchars($item['description']) . "</div>";
            echo "</div>";
        }
        ?>
    </div>

</body>
</html>

<?php
/**
 * Database Installation Script
 * Imports the schema.sql into the database
 */

$config = require '../config/database.php';

// Create connection
$mysqli = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database'],
    $config['port']
);

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// First, drop all existing tables (in reverse order of creation to handle foreign keys)
$dropTables = [
    'DROP TABLE IF EXISTS order_items',
    'DROP TABLE IF EXISTS reviews',
    'DROP TABLE IF EXISTS wishlist',
    'DROP TABLE IF EXISTS cart',
    'DROP TABLE IF EXISTS orders',
    'DROP TABLE IF EXISTS product_images',
    'DROP TABLE IF EXISTS products',
    'DROP TABLE IF EXISTS categories',
    'DROP TABLE IF EXISTS users'
];

foreach ($dropTables as $dropQuery) {
    if (!$mysqli->query($dropQuery)) {
        echo "Warning: " . $mysqli->error . "\n";
    }
}

// Read schema file
$schemaPath = __DIR__ . '/schema.sql';
$schema = file_get_contents($schemaPath);

if ($schema === false) {
    die('Unable to read schema.sql file');
}

// Split queries by semicolon and execute
$queries = array_filter(array_map('trim', explode(';', $schema)));
$queryCount = 0;

foreach ($queries as $query) {
    if (!empty($query)) {
        if (!$mysqli->query($query)) {
            echo "❌ Error executing query: " . $mysqli->error . "\n";
            echo "Query: " . substr($query, 0, 100) . "...\n\n";
        } else {
            $queryCount++;
            echo "✓ Query executed successfully\n";
        }
    }
}

$mysqli->close();
echo "\n✓ Database installation completed! ($queryCount queries executed)\n";
?>

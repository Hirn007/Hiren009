<?php
try {
    // Setup Laravel app
    define('LARAVEL_START', microtime(true));
    
    $app = require __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    
    // Run migrations
    echo "=== Running Database Migrations ===\n\n";
    
    // Execute the migrate command
    $exitCode = $kernel->call('migrate', [
        '--force' => true,
    ]);
    
    if ($exitCode === 0) {
        echo "\n✓ Migrations completed successfully!\n";
        echo "✓ The 'jobs' table has been created.\n";
    } else {
        echo "\n✗ Migration failed with exit code: $exitCode\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

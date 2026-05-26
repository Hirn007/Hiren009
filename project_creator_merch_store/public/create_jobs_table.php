<?php
try {
    $host = '127.0.0.1';
    $db = 'creator_merch_store';
    $user = 'root';
    $pass = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Creating Jobs Table ===\n\n";
    
    // Check if table exists
    $checkTable = $pdo->query("SHOW TABLES LIKE 'jobs'");
    if ($checkTable->rowCount() > 0) {
        echo "✓ Jobs table already exists.\n";
    } else {
        // Create the jobs table
        $sql = "CREATE TABLE `jobs` (
                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `queue` VARCHAR(255) NOT NULL,
                    `payload` LONGTEXT NOT NULL,
                    `attempts` TINYINT UNSIGNED NOT NULL,
                    `reserved_at` INT UNSIGNED NULL,
                    `available_at` INT UNSIGNED NOT NULL,
                    `created_at` INT UNSIGNED NOT NULL,
                    KEY `jobs_queue_index` (`queue`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "✓ Jobs table created successfully!\n";
    }
    
    // Also create job_batches table (if needed)
    $checkBatches = $pdo->query("SHOW TABLES LIKE 'job_batches'");
    if ($checkBatches->rowCount() === 0) {
        echo "\n✓ Creating job_batches table...\n";
        $batchSql = "CREATE TABLE `job_batches` (
                        `id` VARCHAR(255) NOT NULL PRIMARY KEY,
                        `name` VARCHAR(255) NOT NULL,
                        `total_jobs` INT UNSIGNED NOT NULL,
                        `pending_jobs` INT UNSIGNED NOT NULL,
                        `failed_jobs` INT UNSIGNED NOT NULL,
                        `failed_job_ids` LONGTEXT NOT NULL,
                        `options` MEDIUMTEXT NULL,
                        `cancelled_at` INT NULL,
                        `created_at` INT UNSIGNED NOT NULL,
                        `finished_at` INT UNSIGNED NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $pdo->exec($batchSql);
        echo "✓ Job_batches table created successfully!\n";
    } else {
        echo "✓ job_batches table already exists.\n";
    }
    
    echo "\n✓ Database tables are ready!\n";
    echo "✓ Your queue system is now functional.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

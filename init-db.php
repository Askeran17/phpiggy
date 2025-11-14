<?php

// Database initialization script for production
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables for local development, or use system ENV for production
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo "Loaded local .env file...\n";
} else {
    // Use environment variables directly (for Docker/Render)
    echo "Using system environment variables...\n";
}

try {
    // Create database connection
    $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    echo "Connected to the database successfully!\n";

    // Choose SQL file based on database driver
    $driver = $_ENV['DB_DRIVER'] ?? 'mysql';
    $sqlFile = $driver === 'pgsql' ? './database-postgresql.sql' : './database-mysql.sql';
    
    echo "Using SQL file: $sqlFile for driver: $driver\n";
    
    // Read and execute SQL file
    $sqlfile = file_get_contents($sqlFile);
    $statements = explode(';', $sqlfile);

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
            echo "Executed: " . substr($statement, 0, 50) . "...\n";
        }
    }

    echo "Database initialized successfully!\n";

} catch (PDOException $e) {
    echo "Database initialization failed: " . $e->getMessage() . "\n";
    exit(1);
}
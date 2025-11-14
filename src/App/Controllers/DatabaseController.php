<?php

declare(strict_types=1);

namespace App\Controllers;

class DatabaseController
{
    public function initialize()
    {
        // Database initialization script
        require_once __DIR__ . '/../../vendor/autoload.php';

        echo "<h2>Database Initialization</h2>";

        // Load environment variables for local development, or use system ENV for production
        if (file_exists(__DIR__ . '/../../../.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..');
            $dotenv->load();
            echo "<p>Loaded local .env file...</p>";
        } else {
            // Use environment variables directly (for Docker/Render)
            echo "<p>Using system environment variables...</p>";
        }

        try {
            // Get database configuration from environment variables
            $driver = $_ENV['DB_DRIVER'];
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $database = $_ENV['DB_DATABASE'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];
            
            // Validate required environment variables
            if (!$driver || !$host || !$port || !$database || !$username) {
                throw new \Exception('Missing required database environment variables');
            }
            
            echo "<p>Connecting to database...</p>";
            
            // Create DSN based on driver
            if ($driver === 'pgsql') {
                $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
            } else {
                $dsn = "mysql:host={$host};port={$port};dbname={$database}";
            }
            
            // Create database connection
            $pdo = new \PDO($dsn, $username, $password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);

            echo "<p style='color: green;'>✅ Connected to the database successfully!</p>";

            // Choose SQL file based on database driver
            $sqlFile = $driver === 'pgsql' ? __DIR__ . '/../../../database-postgresql.sql' : __DIR__ . '/../../../database-mysql.sql';
            
            echo "<p>Using SQL file: " . basename($sqlFile) . "</p>";
            
            if (!file_exists($sqlFile)) {
                throw new \Exception("SQL file not found: {$sqlFile}");
            }
            
            // Read and execute SQL file
            $sqlContent = file_get_contents($sqlFile);
            $statements = explode(';', $sqlContent);

            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $pdo->exec($statement);
                    echo "<p style='color: blue;'>✅ Executed: " . substr($statement, 0, 50) . "...</p>";
                }
            }

            echo "<h3 style='color: green;'>🎉 Database initialized successfully!</h3>";
            echo "<p><a href='/'>Go to Application</a></p>";

        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Database initialization failed: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p>Please check your database configuration and try again.</p>";
        }
    }
}
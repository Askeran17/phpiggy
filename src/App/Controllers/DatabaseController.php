<?php

declare(strict_types=1);

namespace App\Controllers;

class DatabaseController
{
    public function initialize()
    {
        echo "<h2>Database Initialization</h2>";
        echo "<p>Using system environment variables...</p>";

        try {
            // Get database configuration from environment variables (same as container-definitions.php)
            $driver = $_ENV['DB_DRIVER'] ?? 'mysql';
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $database = $_ENV['DB_NAME']; // Note: DB_NAME not DB_DATABASE
            $username = $_ENV['DB_USER']; // Note: DB_USER not DB_USERNAME  
            $password = $_ENV['DB_PASS']; // Note: DB_PASS not DB_PASSWORD
            
            // Debug info
            echo "<p>Driver: " . ($driver ?: 'NOT SET') . "</p>";
            echo "<p>Host: " . ($host ?: 'NOT SET') . "</p>";
            echo "<p>Database: " . ($database ?: 'NOT SET') . "</p>";
            
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
            $rootDir = dirname(dirname(dirname(__DIR__)));
            $sqlFile = $driver === 'pgsql' ? $rootDir . '/database-postgresql.sql' : $rootDir . '/database-mysql.sql';
            
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
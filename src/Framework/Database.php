<?php

declare(strict_types=1);    

namespace Framework;

use PDO, PDOException, PDOStatement;


class Database 
{
    private PDO $connection;
    private PDOStatement $stmt; 

    public function __construct(
        string $driver, 
        array $config, 
        string $username, 
        string $password
        )
    {
        if ($driver === 'mysql' && isset($config['unix_socket']) && !empty($config['unix_socket'])) {
            // Local development with MAMP
            $dsn = "mysql:unix_socket={$config['unix_socket']};dbname={$config['dbname']}";
        } elseif ($driver === 'pgsql') {
            // PostgreSQL connection - only use valid PostgreSQL options
            $dsnParts = [];
            if (isset($config['host'])) $dsnParts[] = "host={$config['host']}";
            if (isset($config['port'])) $dsnParts[] = "port={$config['port']}";
            if (isset($config['dbname'])) $dsnParts[] = "dbname={$config['dbname']}";
            $dsn = "{$driver}:" . implode(';', $dsnParts);
        } else {
            // Standard MySQL connection
            $config = http_build_query(data: $config, arg_separator: ';');
            $dsn = "{$driver}:{$config}";
        }


try {
    $this->connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Unable to connect to database: " . $e->getMessage() . " | DSN: " . $dsn);
} 
    }    

    public function query(string $query, array $params = []) : Database
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);

        return $this;
    }

    public function count()
    {
        return $this->stmt->fetchColumn();
    }

    public function find(): ?array
    {
        return $this->stmt->fetch();
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    }

    public function findAll(): array
    {
        return $this->stmt->fetchAll();
    }
}


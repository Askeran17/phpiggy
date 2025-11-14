<?php

declare(strict_types=1);

use Framework\{Container, TemplateEngine, Database};
use App\Config\Paths;
use App\Services\{ValidatorService, UserService, TransactionService, ReceiptService};


return [
  TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),
  ValidatorService::class => fn() => new ValidatorService(),
  Database::class => fn() => new Database(
    $_ENV['DB_DRIVER'], [
      'unix_socket' => $_ENV['DB_SOCKET'] ?? '',
      'host' => $_ENV['DB_HOST'] ?? 'localhost',
      'port' => $_ENV['DB_PORT'] ?? '3306',
      'dbname' => $_ENV['DB_NAME'],
    ], $_ENV['DB_USER'], $_ENV['DB_PASS']
  ),
  UserService::class => function (Container $container) {
    $db = $container->get(Database::class);

    return new UserService($db);
  },
  TransactionService::class => function (Container $container) {
    $db = $container->get(Database::class);

    return new TransactionService($db);
  },
  ReceiptService::class => function (Container $container) {
    $db = $container->get(Database::class);

    return new ReceiptService($db);
  },
];
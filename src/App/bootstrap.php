<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

// Подключите файл, содержащий функцию registerRoutes
require __DIR__ . "/Config/routes.php"; // Убедитесь, что путь правильный

use Framework\App;
use function App\Config\registerRoutes;

$app = new App();

registerRoutes($app);

return $app;
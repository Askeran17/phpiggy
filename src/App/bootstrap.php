<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

require __DIR__ . "/Config/Routes.php";

use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};

$app = new App();

registerRoutes($app);
registerMiddleware($app);

return $app;
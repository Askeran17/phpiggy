<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

require __DIR__ . "/Config/Routes.php";
require __DIR__ . "/Config/Middleware.php";

use App\Config\Paths;
use Framework\App;
use Framework\Container;
use function App\Config\{registerRoutes, registerMiddleware};
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();
// Container setup
$container = new Container();
$container->addDefinitions(require __DIR__ . '/container-definitions.php');

$app = new App($container);

registerRoutes($app);
registerMiddleware($app);

return $app;
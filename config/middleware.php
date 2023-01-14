<?php

declare(strict_types = 1);

use app\application\middleware\JsonMiddleware;
use Slim\App;

// Здесь идет подключение необходимых middleware: $app->add(Middleware::class);
return function(App $app) {
    // Подключение обработки ответа в формат JSON
    $app->add(new JsonMiddleware);
};

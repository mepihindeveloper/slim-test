<?php

declare(strict_types = 1);

use app\application\handlers\HttpErrorHandler;
use app\application\handlers\ShutdownHandler;
use app\application\response\emitter\ResponseEmitter;
use DI\ContainerBuilder;
use mepihindeveloper\components\interfaces\ConfigurationInterface;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

// Создание контейнера DI
$containerBuilder = new ContainerBuilder();

// Подключение зависимостей
$settings = require __DIR__ . '/../config/dependencies.php';
$settings($containerBuilder);

// Формируем контейнер
$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Подключение middleware
$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

// Назначение файла кеша маршрутов
$app->getRouteCollector()->setCacheFile(__DIR__ . '/../runtime/cache/router.php');

// Подключение маршрутов
$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

// Получаем настройки для логирования и мониторинга ошибок
$errorConfig = $container->get(ConfigurationInterface::class);
$displayErrorDetails = $errorConfig->getSettingsByKey('displayErrorDetails');
$logError = $errorConfig->getSettingsByKey('logError');
$logErrorDetails = $errorConfig->getSettingsByKey('logErrorDetails');

// Создание глобального объекта запроса
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Создание обработчика ошибок
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Создание обработчика блокирующих (прекращение работы) ошибок
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Подключение стандартный Middleware маршрутизации
$app->addRoutingMiddleware();
// Подключение стандартный Middleware парсинга тела
$app->addBodyParsingMiddleware();

// Подключение стандартного Middleware обработки ошибок
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
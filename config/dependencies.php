<?php

declare(strict_types = 1);

use app\domain\user\UserRepositoryInterface;
use app\infrastructure\repositories\user\DatabaseUserRepositoryInterface;
use DI\ContainerBuilder;
use mepihindeveloper\components\Configuration;
use mepihindeveloper\components\interfaces\ConfigurationInterface;
use function DI\autowire;

$appConfig = require_once __DIR__ . '/data/app.php';

return function(ContainerBuilder $containerBuilder) use ($appConfig) {
    $containerBuilder->addDefinitions([
        // Настройки
        ConfigurationInterface::class => function() use ($appConfig) {
            return new Configuration($appConfig);
        },
        // Соединение с базой данных
        PDO::class => function() use ($appConfig) {
            $pdo = new PDO(
                "pgsql:host={$appConfig['db']['host']};dbname={$appConfig['db']['dbname']}",
                $appConfig['db']['user'],
                $appConfig['db']['pass']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        },
        UserRepositoryInterface::class => autowire(DatabaseUserRepositoryInterface::class)
    ]);
};
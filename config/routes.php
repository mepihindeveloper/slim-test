<?php

declare(strict_types = 1);

use app\presentation\actions\user\ListUsers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function(App $app) {
    $app->get('/', function(Request $request, Response $response) {
        $response->getBody()->write('Hello world!');

        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsers::class);
        //$group->get('/{id}', ViewUserAction::class);
    });

//    $app->get('/users', function(Request $request, Response $response) use ($app) {
//        $container = $app->getContainer();
//        /** @var PDO $pdo */
//        $pdo = $container->get(PDO::class);
//        $sth = $pdo->prepare('SELECT * FROM users');
//        $sth->execute();
//        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
//        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
//
//        return $response;
//    });
};
<?php

declare(strict_types = 1);

namespace app\application\handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;

class HttpErrorHandler extends SlimErrorHandler {

    public const BAD_REQUEST = 'BAD_REQUEST';
    public const INSUFFICIENT_PRIVILEGES = 'INSUFFICIENT_PRIVILEGES';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    public const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';
    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
    public const VERIFICATION_ERROR = 'VERIFICATION_ERROR';

    /**
     * @inheritdoc
     */
    protected function respond(): Response {
        $exception = $this->exception;
        $statusCode = 500;
        $error = [
            'type' => self::SERVER_ERROR,
            'description' => 'При обработке вашего запроса произошла внутренняя ошибка.',
        ];

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
            $error['description'] = $exception->getMessage();

            if ($exception instanceof HttpNotFoundException) {
                $error['type'] = self::RESOURCE_NOT_FOUND;
            } elseif ($exception instanceof HttpMethodNotAllowedException) {
                $error['type'] = self::NOT_ALLOWED;
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $error['type'] = self::UNAUTHENTICATED;
            } elseif ($exception instanceof HttpForbiddenException) {
                $error['type'] = self::INSUFFICIENT_PRIVILEGES;
            } elseif ($exception instanceof HttpBadRequestException) {
                $error['type'] = self::BAD_REQUEST;
            } elseif ($exception instanceof HttpNotImplementedException) {
                $error['type'] = self::NOT_IMPLEMENTED;
            }
        }

        if (
            !($exception instanceof HttpException)
            && $exception instanceof Throwable
            && $this->displayErrorDetails
        ) {
            $error['description'] = $exception->getMessage();
        }

        $payload = array_merge(['code' => $statusCode], $error);
        $encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($encodedPayload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}

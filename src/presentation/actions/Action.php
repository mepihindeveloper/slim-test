<?php

declare(strict_types = 1);

namespace app\presentation\actions;

use app\domain\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

abstract class Action {

    /** @var Request  */
    protected Request $request;
    /** @var Response  */
    protected Response $response;
    /** @var array  */
    protected array $args;

    public function __construct() {
        $a = 1;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @return Response
     */
    abstract protected function action(): Response;
}
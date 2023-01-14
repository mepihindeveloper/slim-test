<?php

declare(strict_types = 1);

namespace app\presentation\actions\user;

use app\domain\user\User;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsers extends BaseUser {

    /** @var User[]  */
    protected array $users;

    protected function action(): Response {
        $users = $this->convertToArray($this->userRepository->findAll());
        $this->response->getBody()->write(json_encode($users, JSON_PRETTY_PRINT));

        return $this->response;
    }

    private function convertToArray(array $users): array {
        $data = [];

        /** @var User $user */
        foreach ($users as $user) {
            $data [] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'age' => $user->getAge(),
            ];
        }

        return $data;
    }
}
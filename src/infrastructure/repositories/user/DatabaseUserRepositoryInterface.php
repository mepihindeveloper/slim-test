<?php

declare(strict_types = 1);

namespace app\infrastructure\repositories\user;

use app\domain\user\User;
use app\domain\user\UserNotFoundException;
use app\domain\user\UserRepositoryInterface;
use PDO;

class DatabaseUserRepositoryInterface implements UserRepositoryInterface {

    protected PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array {
        $sth = $this->pdo->prepare('SELECT * FROM user');
        $sth->execute();

        while($userRecord = $sth->fetch(PDO::FETCH_ASSOC)) {
            $usersList []= new User($userRecord['id'], $userRecord['name'], $userRecord['age']);
        }

        return $usersList ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): User {
        $sth = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $sth->execute(['id' => $id]);
        $userRecord = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$userRecord) {
            throw new UserNotFoundException;
        }

        return new User($userRecord['id'], $userRecord['name'], $userRecord['age']);
    }
}

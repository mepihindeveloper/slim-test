<?php

declare(strict_types = 1);

namespace app\domain\user;

use app\domain\DomainRecordNotFoundException;

interface UserRepositoryInterface {

    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return User
     * @throws DomainRecordNotFoundException
     */
    public function findById(int $id): User;
}
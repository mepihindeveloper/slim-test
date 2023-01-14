<?php

declare(strict_types = 1);

namespace app\presentation\actions\user;

use app\domain\user\UserRepositoryInterface;
use app\presentation\actions\Action;

abstract class BaseUser extends Action {

    /** @var UserRepositoryInterface  */
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        parent::__construct();
        $this->userRepository = $userRepository;
    }
}
<?php

declare(strict_types=1);

namespace app\domain\user;

use app\domain\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException {
    public $message = 'The user you requested does not exist.';
}

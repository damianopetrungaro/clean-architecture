<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception;

use Exception;

class UserPersistenceException extends \Exception
{
    public function __construct($message = 'user_persistence_error', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
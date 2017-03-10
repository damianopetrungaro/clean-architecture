<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception;

use Exception;

class UserNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
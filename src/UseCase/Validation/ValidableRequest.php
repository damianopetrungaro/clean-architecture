<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Validation;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

abstract class ValidableRequest extends Request
{
    /**
     * Method to call for validate a Request.
     * You must use a reference to ResponseInterface to add errors to response.
     *
     * @param ResponseInterface $response
     *
     * @return bool
     */
    abstract public function isValid(ResponseInterface $response) : bool;
}

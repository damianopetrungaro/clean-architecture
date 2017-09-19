<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Validation;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;

interface ValidableRequest extends Request
{
    /**
     * Method to call for validate a Request.
     * You must use a reference to Response to add errors to response.
     *
     * @param Response $response
     *
     * @return bool
     */
    public function isValid(Response $response): bool;
}

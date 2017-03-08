<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Validation;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

interface ValidableRequestInterface extends RequestInterface
{
    /**
     * Method to call for validate a Request.
     * You must use a reference to ResponseInterface to add errors to response.
     *
     * @param ResponseInterface $response
     *
     * @return bool
     */
    public function isValid(ResponseInterface $response) : bool;
}

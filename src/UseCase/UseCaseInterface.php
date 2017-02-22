<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

interface UseCaseInterface
{
    /**
     * Method to call for initialize the use case.
     * You must use a reference to ResponseInterface to return the response.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response) : void;
}

<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase;


use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

interface UseCaseInterface
{
    /**
     * Initialize the use case.
     * Must use a reference to ResponseInterface to return the response.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response) : void;
}
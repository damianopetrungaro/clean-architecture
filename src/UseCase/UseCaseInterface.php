<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase;


use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

interface UseCaseInterface
{
    public function __invoke(RequestInterface $request, ResponseInterface $response) : void;
}
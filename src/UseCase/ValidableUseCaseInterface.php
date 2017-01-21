<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase;


use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

interface ValidableUseCaseInterface extends UseCaseInterface
{
    /**
     * Method to call for validate an UseCase.
     * You must use a reference to ResponseInterface to add errors to response.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return bool
     */
    public function isValid(RequestInterface $request, ResponseInterface $response) : bool;
}
<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;

interface UseCase
{
    /**
     * Method to call for initialize the use case.
     * You must use a reference to Response to return the response.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return void
     */
    public function __invoke(Request $request, Response $response): void;
}

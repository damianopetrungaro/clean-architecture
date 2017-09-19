<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Validation;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitecture\UseCase\UseCase;

interface ValidableUseCase extends UseCase
{
    /**
     * Method to call for validate an UseCase.
     * You must use a reference to Response to add errors to response.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return bool
     */
    public function isValid(Request $request, Response $response): bool;
}

<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;

interface Error
{
    /**
     * Return the error code.
     *
     * @return string
     */
    public function code(): string;

    /**
     * Return the error type.
     *
     * @return ErrorType
     */
    public function type(): ErrorType;
}

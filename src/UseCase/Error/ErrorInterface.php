<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;


interface ErrorInterface
{
    /**
     * Return the error code.
     *
     * @return string
     */
    public function code() : string;

    /**
     * Return the error type.
     *
     * @return ErrorType
     */
    public function type() : ErrorType;
}
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
     * @return ErrorTypeInterface
     */
    public function type() : ErrorTypeInterface;
}
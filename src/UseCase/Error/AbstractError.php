<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;


abstract class AbstractError
{
    /**
     * Error code.
     *
     * @var string
     */
    protected $code;

    /**
     * Error type.
     *
     * @var ErrorType
     */
    protected $type;

    /**
     * Error constructor.
     *
     * @param string $code Error code
     * @param ErrorType $type Specify error using an enum.
     */
    public function __construct(string $code, ErrorType $type)
    {
        $this->code = $code;
        $this->type = $type;
    }

    /**
     * Return the error code.
     *
     * @return string
     */
    public function code() : string
    {
        return $this->code;
    }

    /**
     * Return the error type.
     *
     * @return ErrorType
     */
    public function type() : ErrorType
    {
        return $this->type;
    }
}
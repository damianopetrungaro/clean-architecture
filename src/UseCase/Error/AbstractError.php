<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;


class AbstractError implements ErrorInterface
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var ErrorTypeInterface
     */
    private $errorType;

    /**
     * AbstractError constructor.
     *
     * @param string $code
     * @param ErrorTypeInterface $errorType
     */
    public function __construct(string $code, ErrorTypeInterface $errorType)
    {
        $this->code = $code;
        $this->errorType = $errorType;
    }

    /**
     * {@inheritDoc}
     */
    public function code() : string
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function type() : ErrorTypeInterface
    {
        return $this->type;
    }
}
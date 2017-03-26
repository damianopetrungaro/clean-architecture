<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;

abstract class AbstractError implements ErrorInterface
{
    /**
     * @var string $code
     */
    private $code;

    /**
     * @var ErrorTypeInterface $errorType
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
        return $this->errorType;
    }
}

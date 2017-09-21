<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;

abstract class AbstractError implements Error
{
    /**
     * @var string $code
     */
    private $code;

    /**
     * @var ErrorType $errorType
     */
    private $errorType;

    /**
     * AbstractError constructor.
     *
     * @param string $code
     * @param ErrorType $errorType
     */
    public function __construct(string $code, ErrorType $errorType)
    {
        $this->code = $code;
        $this->errorType = $errorType;
    }

    /**
     * {@inheritDoc}
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function type(): ErrorType
    {
        return $this->errorType;
    }
}

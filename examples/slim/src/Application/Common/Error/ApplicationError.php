<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Error;


use Damianopetrungaro\CleanArchitecture\UseCase\Error\AbstractError;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorTypeInterface;

class ApplicationError extends AbstractError
{
    /**
     * @var string
     */
    private $pointer;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var array
     */
    private $meta;

    /**
     * ApplicationError constructor.
     * @param string $code
     * @param ErrorTypeInterface $errorType
     * @param string $pointer
     * @param string $title
     * @param string $detail
     * @param array $meta
     */
    public function __construct($code, ErrorTypeInterface $errorType, string $pointer = '', string $title = '', string $detail = '', array $meta = [])
    {
        parent::__construct($code, $errorType);
        $this->pointer = $pointer;
        $this->title = $title;
        $this->detail = $detail;
        $this->meta = $meta;
    }

    /**
     * Return the error pointer
     *
     * @return string
     */
    public function pointer()
    {
        return $this->pointer;
    }

    /**
     * Return the error title
     *
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the error detail
     *
     * @return string
     */
    public function detail(): string
    {
        return $this->detail;
    }

    /**
     * Return the error meta
     *
     * @return array
     */
    public function meta(): array
    {
        return $this->meta;
    }
}
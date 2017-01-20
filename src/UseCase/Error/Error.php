<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;


class Error
{
    /**
     * Error code
     *
     * @var string
     */
    protected $code;

    /**
     * Error detail
     *
     * @var mixed
     */
    protected $detail;

    /**
     * Error meta information
     *
     * @var array
     */
    protected $meta;

    /**
     * Error pointer
     * (Object containing references to the source of the error inspired by jsonapi.org)
     * @link http://jsonapi.org/format/#errors
     *
     * @var mixed
     */
    protected $pointer;

    /**
     * Error title
     *
     * @var mixed
     */
    protected $title;

    /**
     * Error type
     *
     * @var ErrorType
     */
    protected $type;

    /**
     * Error constructor.
     *
     * @param string $code Error code
     * @param ErrorType $type Specify error using an enum
     * @param string|null $title Optional title
     * @param string|null $detail Optional detail
     * @param string|null $pointer Optional pointer
     * @param array $meta Optional meta information
     */
    public function __construct(string $code, ErrorType $type, string $title = null, string $detail = null, string $pointer = null, array $meta = [])
    {
        $this->code = $code;
        $this->type = $type;
        $this->title = $title;
        $this->detail = $detail;
        $this->pointer = $pointer;
        $this->meta = $meta;
    }

    /**
     * Return the error code
     *
     * @return string
     */
    public function code() : string
    {
        return $this->code;
    }

    /**
     * Return the detail
     *
     * @return mixed
     */
    public function detail() : ?string
    {
        return $this->detail;
    }

    /**
     * Return the meta information
     *
     * @return array
     */
    public function meta() : array
    {
        return $this->meta;
    }

    /**
     * @return mixed
     */
    public function pointer() : ?string
    {
        return $this->pointer;
    }

    /**
     * Return the title
     *
     * @return mixed
     */
    public function title() : ?string
    {
        return $this->title;
    }

    /**
     * Return the error type
     *
     * @return ErrorType
     */
    public function type() : ErrorType
    {
        return $this->type;
    }
}
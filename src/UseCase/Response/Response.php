<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;


use Damianopetrungaro\CleanArchitecture\Common\Collection\CollectionInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;

class Response implements ResponseInterface
{
    /**
     * Available Response status
     */
    protected const STATUS_FAILED = 'FAILED';
    protected const STATUS_SUCCESSFUL = 'SUCCESSFUL';

    /**
     * @var string $status
     */
    protected $status;

    /**
     * Contains the error list
     * (This list contains of data to show in case of failure)
     *
     * @var CollectionInterface $errors
     */
    protected $errors;

    /**
     * Contains the data list
     * (This list contains of data to show in case of success)
     *
     * @var CollectionInterface $data
     */
    protected $data;

    /**
     * Response constructor.
     *
     * @param CollectionInterface $data
     * @param CollectionInterface $errors
     */
    public function __construct(CollectionInterface $data, CollectionInterface $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * {@inheritDoc}
     */
    public function addData($key, $value) : void
    {
        $this->data->set($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function addError($key, Error $error) : void
    {
        $this->errors->set($key, $error);
    }

    /**
     * {@inheritDoc}
     */
    public function getData() : array
    {
        return $this->data->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getError() : array
    {
        return $this->errors->all();
    }

    /**
     * {@inheritDoc}
     */
    public function hasData() : bool
    {
        return (bool)$this->data->length();
    }

    /**
     * {@inheritDoc}
     */
    public function hasError() : bool
    {
        return (bool)$this->errors->length();
    }

    /**
     * {@inheritDoc}
     */
    public function isFailed() : bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * {@inheritDoc}
     */
    public function isSuccessful() : bool
    {
        return $this->status === self::STATUS_SUCCESSFUL;
    }

    /**
     * {@inheritDoc}
     */
    public function setAsFailed() : void
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * {@inheritDoc}
     */
    public function setAsSuccess() : void
    {
        $this->status = self::STATUS_SUCCESSFUL;
    }
}
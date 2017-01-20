<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;


use Damianopetrungaro\CleanArchitecture\Common\CollectionInterface;
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
     * Add data to the data list
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function addData($key, $value) : void
    {
        $this->data->add($key, $value);
    }

    /**
     * Add an Error to the error list
     *
     * @param $key
     * @param Error $error
     *
     * @return void
     */
    public function addError($key, Error $error) : void
    {
        $this->errors->add($key, $error);
    }

    /**
     * Return the data list content
     *
     * @return array
     */
    public function getData() : array
    {
        return $this->data->all();
    }

    /**
     * Return the error list content
     *
     * @return array
     */
    public function getError() : array
    {
        return $this->errors->all();
    }

    /**
     * Return true if data list is not empty, otherwise return false
     *
     * @return bool
     */
    public function hasData() : bool
    {
        return (bool)$this->data->length();
    }

    /**
     * Return true if error list is not empty, otherwise return false
     *
     * @return bool
     */
    public function hasError() : bool
    {
        return (bool)$this->errors->length();
    }

    /**
     * Check if Response is failed
     *
     * @return bool
     */
    public function isFailed() : bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if Response is successful
     *
     * @return bool
     */
    public function isSuccessful() : bool
    {
        return $this->status === self::STATUS_SUCCESSFUL;
    }

    /**
     * Set the response as failed
     *
     * @return void
     */
    public function setAsFailed() : void
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * Set the response as success
     *
     * @return void
     */
    public function setAsSuccess() : void
    {
        $this->status = self::STATUS_SUCCESSFUL;
    }
}
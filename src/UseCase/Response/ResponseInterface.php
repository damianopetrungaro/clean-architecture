<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;


use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;

interface ResponseInterface
{
    /**
     * Add data to the data list.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function addData($key, $value) : void;

    /**
     * Add an Error to the error list.
     *
     * @param $key
     * @param Error $error
     *
     * @return void
     */
    public function addError($key, Error $error) : void;

    /**
     * Return the data list content.
     *
     * @return array
     */
    public function getData() : array;

    /**
     * Return the error list content.
     *
     * @return array
     */
    public function getError() : array;

    /**
     * Return true if data list is not empty, otherwise return false.
     *
     * @return bool
     */
    public function hasData() : bool;

    /**
     * Return true if error list is not empty, otherwise return false.
     *
     * @return bool
     */
    public function hasError() : bool;

    /**
     * Check if Response is failed.
     *
     * @return bool
     */
    public function isFailed() : bool;

    /**
     * Check if Response is successful.
     *
     * @return bool
     */
    public function isSuccessful() : bool;

    /**
     * Set the response as failed.
     *
     * @return void
     */
    public function setAsFailed() : void;

    /**
     * Set the response as success.
     *
     * @return void
     */
    public function setAsSuccess() : void;
}
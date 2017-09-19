<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;

interface Response
{
    /**
     * Available Response status
     */
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_SUCCESSFUL = 'SUCCESSFUL';

    /**
     * Replace data to the data list by key.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function replaceData($key, $value): void;

    /**
     * Replace an Error to the error list by key.
     *
     * @param $key
     * @param Error $error
     *
     * @return void
     */
    public function replaceError($key, Error $error): void;

    /**
     * Add data to the data list by key.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function addData($key, $value): void;

    /**
     * Add an Error to the error list by key.
     *
     * @param $key
     * @param Error $error
     *
     * @return void
     */
    public function addError($key, Error $error): void;

    /**
     * Return the data list content.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Return the error list content.
     *
     * @return array
     */
    public function getErrors(): array;

    /**
     * Return true if data list is not empty, otherwise return false.
     *
     * @return bool
     */
    public function hasData(): bool;

    /**
     * Return true if error list is not empty, otherwise return false.
     *
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * Check if Response is failed.
     *
     * @return bool
     */
    public function isFailed(): bool;

    /**
     * Check if Response is successful.
     *
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * Remove data to the data list.
     *
     * @param $key
     *
     * @return void
     */
    public function removeData($key): void;

    /**
     * Remove an Error to the error list.
     *
     * @param $key
     *
     * @return void
     */
    public function removeError($key): void;

    /**
     * Set the response as failed.
     *
     * @return void
     */
    public function setAsFailed(): void;

    /**
     * Set the response as success.
     *
     * @return void
     */
    public function setAsSuccess(): void;
}

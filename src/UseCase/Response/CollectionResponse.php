<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;
use function is_array;

class CollectionResponse implements Response
{
    /**
     * @var string $status
     */
    private $status;

    /**
     * Contains the error list
     * (This list contains of data to show in case of failure)
     *
     * @var Collection $errors
     */
    private $errors;

    /**
     * Contains the data list
     * (This list contains of data to show in case of success)
     *
     * @var Collection $data
     */
    private $data;

    /**
     * CollectionResponse constructor.
     *
     * @param Collection $data
     * @param Collection $errors
     */
    public function __construct(Collection $data, Collection $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * ATTENTION: If the data is an array, the content will be added to the existing array
     * {@inheritDoc}
     */
    public function addData($key, $value): void
    {
        $values = $this->data->get($key, []);
        is_array($values) ?: $values = [$values];
        $values[] = $value;
        $this->data = $this->data->with($key, $values);
    }

    /**
     * {@inheritDoc}
     */
    public function addError($key, Error $error): void
    {
        $errors = $this->errors->get($key, []);
        is_array($errors) ?: $errors = [$errors];
        $errors[] = $error;
        $this->errors = $this->errors->with($key, $errors);
    }

    /**
     * {@inheritDoc}
     */
    public function replaceData($key, $value): void
    {
        $this->data = $this->data->with($key, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function replaceError($key, Error $error): void
    {
        $this->errors = $this->errors->with($key, $error);
    }

    /**
     * {@inheritDoc}
     */
    public function getData(): array
    {
        return $this->data->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors->all();
    }

    /**
     * {@inheritDoc}
     */
    public function hasData(): bool
    {
        return $this->data->length() !== 0;
    }

    /**
     * {@inheritDoc}
     */
    public function hasErrors(): bool
    {
        return $this->errors->length() !== 0;
    }

    /**
     * {@inheritDoc}
     */
    public function isFailed(): bool
    {
        return $this->status === Response::STATUS_FAILED;
    }

    /**
     * {@inheritDoc}
     */
    public function isSuccessful(): bool
    {
        return $this->status === Response::STATUS_SUCCESSFUL;
    }

    /**
     * {@inheritDoc}
     */
    public function removeData($key): void
    {
        $this->data = $this->data->without($key);
    }

    /**
     * {@inheritDoc}
     */
    public function removeError($key): void
    {
        $this->errors = $this->errors->without($key);
    }

    /**
     * {@inheritDoc}
     */
    public function setAsFailed(): void
    {
        $this->status = Response::STATUS_FAILED;
    }

    /**
     * {@inheritDoc}
     */
    public function setAsSuccess(): void
    {
        $this->status = Response::STATUS_SUCCESSFUL;
    }
}

<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;

class CollectionResponse implements Response
{
    /**
     * Available CollectionResponse status
     */
    protected const STATUS_FAILED = 'FAILED';
    protected const STATUS_SUCCESSFUL = 'SUCCESSFUL';

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
     * {@inheritDoc}
     */
    public function addData($key, $value): void
    {
        $values = $this->data->get($key, []);
        $values[] = $value;
        $this->data = $this->data->with($values, $key);
    }

    /**
     * {@inheritDoc}
     */
    public function addError($key, Error $error): void
    {
        $values = $this->errors->get($key, []);
        $values[] = $error;
        $this->errors = $this->errors->with($values, $key);
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
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * {@inheritDoc}
     */
    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCESSFUL;
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
        $this->status = self::STATUS_FAILED;
    }

    /**
     * {@inheritDoc}
     */
    public function setAsSuccess(): void
    {
        $this->status = self::STATUS_SUCCESSFUL;
    }
}

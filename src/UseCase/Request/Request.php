<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Request;

interface Request
{
    /**
     * Return all the data.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Remove all the data.
     *
     * @return Request
     */
    public function clear(): Request;

    /**
     * Return the value of required key.
     * Default if is not found.
     *
     * @param mixed $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Return true if key is set, otherwise false.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has($key): bool;

    /**
     * Return a Request with a new data value.
     *
     *
     * @param mixed $data
     * @param mixed $key
     *
     * @return Request
     */
    public function with($data, $key = null): Request;

    /**
     * Return a Request without a specific key.
     *
     * @param mixed $key
     *
     * @return Request
     */
    public function without($key): Request;
}

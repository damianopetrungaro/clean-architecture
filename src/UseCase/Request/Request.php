<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Request;

use Damianopetrungaro\CleanArchitecture\Common\Collection\CollectionInterface;
use Damianopetrungaro\CleanArchitecture\Common\CommonTrait\CloneArrayTrait;

class Request implements RequestInterface
{
    use CloneArrayTrait;

    /**
     * @var CollectionInterface $collection
     */
    #protected $collection;
    public $collection;

    /**
     * Request constructor.
     *
     * @param CollectionInterface $collection
     */
    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->collection->all();
    }

    /**
     * Remove all the data.
     *
     * @return RequestInterface
     */
    public function clear(): RequestInterface
    {
        $clone = clone $this;
        $clone->collection = $clone->collection->clear();

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return $this->collection->get($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function has($key): bool
    {
        return $this->collection->has($key);
    }

    /**
     * {@inheritDoc}
     */
    public function with($data, $key = null): RequestInterface
    {
        $clone = clone $this;
        $clone->collection = $clone->collection->with($data, $key);

        return $clone;
    }

    /**
     * Return a RequestInterface without a specific key.
     *
     * @param mixed $key
     *
     * @return RequestInterface
     */
    public function without($key): RequestInterface
    {
        $clone = clone $this;
        $clone->collection = $clone->collection->without($key);

        return $clone;
    }
}

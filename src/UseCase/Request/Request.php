<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\CollectionInterface;

class Request implements RequestInterface
{
    /**
     * @var CollectionInterface $collection
     */
    protected $collection;

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
    public function all() : array
    {
        return $this->collection->all();
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
    public function has($key) : bool
    {
        return $this->collection->has($key);
    }

    /**
     * {@inheritDoc}
     */
    public function with($item, $key = null) : RequestInterface
    {
        return $this->collection->with($item, $key);
    }
}
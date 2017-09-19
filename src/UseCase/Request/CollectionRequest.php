<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Request;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\Common\CommonTrait\CloneArrayTrait;

class CollectionRequest implements Request
{
    use CloneArrayTrait;

    /**
     * @var Collection $collection
     */
    private $collection;

    /**
     * CollectionRequest constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
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
     * {@inheritDoc}
     */
    public function clear(): Request
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
    public function with($data, $key = null): Request
    {
        $clone = clone $this;
        $clone->collection = $clone->collection->with($data, $key);

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function without($key): Request
    {
        $clone = clone $this;
        $clone->collection = $clone->collection->without($key);

        return $clone;
    }
}

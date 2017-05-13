<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\Common\Collection;

use Damianopetrungaro\CleanArchitecture\Common\CommonTrait\CloneArrayTrait;

class Collection implements CollectionInterface
{
    use CloneArrayTrait;

    /**
     * Array of request parameters.
     *
     * @var array $items
     */
    private $items;

    /**
     * Request constructor.
     *
     * @param array $items Populate the items.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * {@inheritDoc}
     */
    public function clear() : CollectionInterface
    {
        $clone = clone $this;
        $clone->items = [];

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function contains($item, bool $strict = true) : bool
    {
        return in_array($item, $this->items, $strict);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return isset($this->items[$key]) ? $this->items[$key] : $default;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key) : bool
    {
        return isset($this->items[$key]);
    }

    /**
     * {@inheritDoc}
     */
    public function keys() : array
    {
        return array_keys($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function length() : int
    {
        return count($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function mergeWith(CollectionInterface...$collections) : CollectionInterface
    {
        $clone = clone $this;
        foreach ($collections as $collection) {
            $clone->items = array_merge($clone->all(), $collection->all());
        }

        return $clone;
    }

    /**
     * @inheritdoc
     */
    public function all() : array
    {
        return $this->items;
    }

    /**
     * {@inheritDoc}
     */
    public function with($item, $key = null) : CollectionInterface
    {
        $clone = clone $this;
        ($key !== null) ? $clone->items[$key] = $item : $clone->items[] = $item;

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function without($key) : CollectionInterface
    {
        $clone = clone $this;
        unset($clone->items[$key]);

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function values() : array
    {
        return array_values($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function __clone()
    {
        $this->cloneArray($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        foreach ($this->items as $key => $item) {
            yield $key => $item;
        }
    }
}

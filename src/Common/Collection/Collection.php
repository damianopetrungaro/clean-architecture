<?php

namespace Damianopetrungaro\CleanArchitecture\Common\Collection;


class Collection implements CollectionInterface
{
    /**
     * Array of request parameters.
     *
     * @var array $items
     */
    protected $items;

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
     * @inheritdoc
     */
    public function all() : array
    {
        return $this->items;
    }

    /**
     * {@inheritDoc}
     */
    public function clear() : void
    {
        $this->items = [];
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
     * Return an array containing all the collection's keys
     *
     * @return array
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
    public function merge(CollectionInterface ...$collections) : CollectionInterface
    {
        $clone = clone $this;
        foreach ($collections as $collection) {
            $clone->items = array_merge($this->all(), $collection->all());
        }

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key) : CollectionInterface
    {
        $clone = clone $this;
        unset($clone->items[$key]);

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function set($item, $key = null) : CollectionInterface
    {
        $clone = clone $this;
        (func_num_args() == 2) ? $clone->items[$key] = $item : $clone->items[] = $item;

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function values() : array
    {
        return array_values($this->items);
    }
}
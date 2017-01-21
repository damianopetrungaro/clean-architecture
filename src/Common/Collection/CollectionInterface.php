<?php

namespace Damianopetrungaro\CleanArchitecture\Common\Collection;


interface CollectionInterface
{
    /**
     * Return all the items.
     *
     * @return array
     */
    public function all() : array;

    /**
     * Remove all the keys.
     *
     * @return void
     */
    public function clear() : void;

    /**
     * Return true if collection contains the required value, otherwise return false.
     *
     * @param mixed $item
     *
     * @param bool $strict
     *
     * @return bool
     */
    public function contains($item, bool $strict = true) : bool;

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
    public function has($key) : bool;

    /**
     * Return an array containing all the collection's keys.
     *
     * @return array
     */
    public function keys() : array;

    /**
     * Return the number of items.
     *
     * @return int
     */
    public function length() : int;

    /**
     * Merge with one or more collection.
     *
     * @param CollectionInterface[] $collection
     *
     * @return CollectionInterface
     */
    public function merge(CollectionInterface ...$collection) : CollectionInterface;

    /**
     * Remove a specific key.
     *
     * @param mixed $key
     *
     * @return CollectionInterface
     */
    public function remove($key) : CollectionInterface;

    /**
     * Add or override an item.
     *
     * @param mixed $item
     * @param mixed $key
     *
     * @return CollectionInterface
     */
    public function set($item, $key = null) : CollectionInterface;

    /**
     * Return an array containing all the collection's items.
     *
     * @return array
     */
    public function values() : array;
}
<?php

namespace Damianopetrungaro\CleanArchitecture\Common;


interface CollectionInterface
{
    /**
     * Add or override an entry
     *
     * @param mixed $key
     * @param mixed $entry
     *
     * @return void
     */
    public function add(mixed $key, mixed $entry) : void;

    /**
     * Return all the entries
     *
     * @return array
     */
    public function all() : array;

    /**
     * Remove all the keys
     *
     * @return void
     */
    public function clear() : void;

    /**
     * Return the value of required key.
     * Default if is not found,
     *
     * @param mixed $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(mixed $key, mixed $default = null) : mixed;

    /**
     * Return true if key is set, otherwise false
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has(mixed $key) : bool;

    /**
     * Return the number of entries
     *
     * @return int
     */
    public function length() : int;

    /**
     * Merge with one or more collection
     *
     * @param CollectionInterface[] $collection
     *
     */
    public function merge(CollectionInterface ...$collection) : void;

    /**
     * Remove a specific key.
     *
     * @param mixed $key
     *
     * @return void
     */
    public function remove(mixed $key) : void;
}
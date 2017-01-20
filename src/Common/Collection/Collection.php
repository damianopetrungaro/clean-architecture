<?php

namespace Damianopetrungaro\CleanArchitecture\Common\Collection;


use Damianopetrungaro\CleanArchitecture\Common\CollectionInterface;

class Collection implements CollectionInterface
{
    /**
     * Array of request parameters
     *
     * @var array $entries
     */
    protected $entries;

    /**
     * Request constructor.
     *
     * @param array $entries Populate the entries.
     */
    public function __construct(array $entries = [])
    {
        $this->entries = $entries;
    }

    /**
     * Add or override an entry
     *
     * @param mixed $key
     * @param mixed $entry
     *
     * @return void
     */
    public function add(mixed $key, mixed $entry) : void
    {
        $this->entries[$key] = $entry;
    }

    /**
     * Return all the entries
     *
     * @return array
     */
    public function all() : array
    {
        return $this->entries;
    }

    /**
     * Remove all the keys from the Request
     *
     * @return void
     */
    public function clear() : void
    {
        $this->entries = [];
    }

    /**
     * Return a value from the request.
     * Default if is not found,
     *
     * @param mixed $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(mixed $key, mixed $default = null) : mixed
    {
        return isset($this->entries[$key]) ? $this->entries[$key] : $default;
    }

    /**
     * Return true if key is set, otherwise false
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has(mixed $key) : bool
    {
        return isset($this->entries[$key]);
    }

    /**
     * Return the number of entries
     *
     * @return int
     */
    public function length() : int
    {
        return count($this->entries);
    }

    /**
     * Merge with one or more collection
     *
     * @param CollectionInterface[] $collections
     *
     */
    public function merge(CollectionInterface ...$collections) : void
    {
        foreach ($collections as $collection) {
            array_merge($this->all(), $collection->all());
        }
    }

    /**
     * Remove a key from the Request
     *
     * @param mixed $key
     *
     * @return void
     */
    public function remove(mixed $key) : void
    {
        unset($this->entries[$key]);
    }

}
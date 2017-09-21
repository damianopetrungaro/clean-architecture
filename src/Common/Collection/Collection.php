<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\Common\Collection;

interface Collection extends \IteratorAggregate
{
    /**
     * Return all the items.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Remove all the items.
     *
     * @return Collection
     */
    public function clear(): Collection;

    /**
     * Return true if collection contains the required value, otherwise return false.
     *
     * @param mixed $item
     * @param bool $strict
     *
     * @return bool
     */
    public function contains($item, bool $strict = true): bool;

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
     * Return an array containing all the collection's keys.
     *
     * @return array
     */
    public function keys(): array;

    /**
     * Return the number of items.
     *
     * @return int
     */
    public function length(): int;

    /**
     * Return a Collection merging it with one or more collection.
     *
     * @param Collection[] $collection
     *
     * @return Collection
     */
    public function mergeWith(Collection...$collection): Collection;

    /**
     * Return a Collection with a new item value.
     *
     * @param mixed $key
     * @param mixed $item
     *
     * @return Collection
     */

    public function with($key, $item): Collection;

    /**
     * Return a Collection without a specific key.
     *
     * @param mixed $key
     *
     * @return Collection
     */
    public function without($key): Collection;

    /**
     * Return an array containing all the collection's items.
     *
     * @return array
     */
    public function values(): array;

    /**
     * Return a new cloned object
     * It's recommended to deep clone the object
     *
     * @return Collection
     */
    public function __clone();
}

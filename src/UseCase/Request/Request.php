<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;

class Request extends Collection implements RequestInterface
{
    /**
     * {@inheritDoc}
     */
    public function clear() : RequestInterface
    {
        $clone = clone $this;
        $clone->items = [];

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function mergeWith(...$collections) : RequestInterface
    {
        $clone = clone $this;
        foreach ($collections as $collection) {

            if (!$collection instanceof RequestInterface) {
                throw new \InvalidArgumentException("$collection must implement RequestInterface");
            }

            $clone->items = array_merge($clone->all(), $collection->all());
        }

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function without($key) : RequestInterface
    {
        $clone = clone $this;
        unset($clone->items[$key]);

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function with($item, $key = null) : RequestInterface
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
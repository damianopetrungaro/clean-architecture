<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\Common\CommonTrait;

trait CloneArrayTrait
{
    /**
     * Return a cloned array from an array reference.
     *
     * @param array $array
     *
     * @return array
     */
    protected function cloneArray(array &$array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->cloneArray($value);
                continue;
            }

            if (is_object($value)) {
                $array[$key] = clone $value;
                continue;
            }
        }

        return $array;
    }
}

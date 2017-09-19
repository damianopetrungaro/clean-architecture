<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\Mapper;

interface Mapper
{
    /**
     * Transform an object into an array
     *
     * @param $object
     *
     * @return array
     */
    public function toArray($object): array;

    /**
     * Transform an array into an object
     *
     * @param $class
     * @param array $array
     *
     * @return mixed
     */
    public function toObject($class, array $array);
}

<?php

namespace Damianopetrungaro\CleanArchitecture\Mapper;

interface MapperInterface
{
    /**
     * Transform an object into an array
     *
     * @param $object
     *
     * @return array
     */
    public function toArray($object) : array;

    /**
     * Transform an array into an object
     *
     * @param $className
     * @param array $array
     *
     * @return mixed
     */
    public function toObject($className, array $array);
}
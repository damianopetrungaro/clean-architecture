<?php

namespace Damianopetrungaro\CleanArchitecture\Common;


use ReflectionClass;

abstract class Enum
{
    /**
     * Throw an exception if there's no constant in the child class, otherwise return the constant value
     *
     * @param string $enum
     * @param array $args
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public static function __callStatic(string $enum, array $args = []) : string
    {
        $self = new ReflectionClass(static::class);
        if (!isset($self->getConstants()[$enum])) {
            throw new \InvalidArgumentException("$enum is not available in " . static::class);
        }
        return $self->getConstants()[$enum];
    }
}
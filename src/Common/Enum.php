<?php

namespace Damianopetrungaro\CleanArchitecture\Common;


use ReflectionClass;

/**
 * The class that will extents Enum should only contains constant.
 * Example:
 *
 * const ERROR_VALIDATION = 'ERROR_VALIDATION';
 * const ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';
 * const PERSISTENCE_ERROR= 'PERSISTENCE_ERROR';
 */
abstract class Enum
{
    /**
     * Throw an exception if there's no constant in the child class, otherwise return the constant value.
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
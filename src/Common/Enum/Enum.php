<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\Common\Enum;

use ReflectionClass;

/**
 * The class that will extents Enum should only contains constant.
 * Example:
 *
 * protected const ERROR_VALIDATION = 'ERROR_VALIDATION';
 * protected const ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';
 * protected const PERSISTENCE_ERROR= 'PERSISTENCE_ERROR';
 */
class Enum implements EnumInterface
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
    public static function __callStatic(string $enum, array $args = []): string
    {
        $self = new ReflectionClass(static::class);
        $constants = $self->getConstants();

        if (!isset($constants[$enum])) {
            throw new \InvalidArgumentException("$enum is not available in " . static::class);
        }

        return $constants[$enum];
    }
}

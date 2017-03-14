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
     * @var string $value
     */
    protected $value;

    /**
     * {@inheritDoc}
     */
    public static function __callStatic(string $value, array $args = []): EnumInterface
    {
        $self = new ReflectionClass(static::class);
        $constants = $self->getConstants();

        if (!isset($constants[$value])) {
            throw new \InvalidArgumentException("$value is not available in " . static::class);
        }

        $enum = new static();
        $enum->value = $constants[$value];

        return $enum;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

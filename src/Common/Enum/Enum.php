<?php

declare(strict_types = 1);

namespace Damianopetrungaro\CleanArchitecture\Common\Enum;

use ReflectionClass;

/**
 * The class that will extents Enum should only contains constant.
 * Example:
 *
 * public const ERROR_VALIDATION = 'ERROR_VALIDATION';
 * public const ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';
 * public const PERSISTENCE_ERROR= 'PERSISTENCE_ERROR';
 */
abstract class Enum implements EnumInterface
{
    /**
     * @var string $value
     */
    protected $value;

    /**
     * {@inheritDoc}
     */
    public function __construct($value)
    {
        $self = new ReflectionClass(static::class);
        $constants = $self->getConstants();

        if (!in_array($value, $constants)) {
            throw new \InvalidArgumentException(sprintf('The value "%s" is not available in %s', $value, static::class));
        }

        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public static function __callStatic(string $value, array $args = []): EnumInterface
    {
        $self = new ReflectionClass(static::class);
        $constants = $self->getConstants();

        if (!array_key_exists($value, $constants)) {
            throw new \InvalidArgumentException(sprintf('The key "%s" is not available in %s', $value, static::class));
        }

        return new static($constants[$value]);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return (string)$this->getValue();
    }
}

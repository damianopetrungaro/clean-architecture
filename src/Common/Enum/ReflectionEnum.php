<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\Common\Enum;

use InvalidArgumentException;
use ReflectionClass;

/**
 * The class that extents ReflectionEnum should only contains constant.
 * Example:
 *
 * public const ERROR_VALIDATION = 'ERROR_VALIDATION';
 * public const ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';
 * public const PERSISTENCE_ERROR= 'PERSISTENCE_ERROR';
 */
abstract class ReflectionEnum implements Enum
{
    /**
     * @var string $value
     */
    protected $value;

    /**
     * {@inheritDoc}
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        $constants = static::getAllowedValues();

        if (!in_array($value, $constants, true)) {
            throw new InvalidArgumentException(sprintf('The value "%s" is not available in %s', $value, static::class));
        }

        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public static function __callStatic(string $value, array $args = []): Enum
    {
        $constants = static::getAllowedValues();

        if (!array_key_exists($value, $constants)) {
            throw new InvalidArgumentException(sprintf('The key "%s" is not available in %s', $value, static::class));
        }

        return new static($constants[$value]);
    }

    /**
     * {@inheritDoc}
     */
    public static function getAllowedValues(): array
    {
        $self = new ReflectionClass(static::class);

        return $self->getConstants();
    }

    /**
     * {@inheritDoc}
     */
    public abstract function equals($enum): bool;

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}

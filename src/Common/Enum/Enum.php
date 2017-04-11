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
abstract class Enum implements EnumInterface
{
    /**
     * @var string $value
     */
    private $value;

    /**
     * Enum constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!static::isValid($value)) {
            throw new \InvalidArgumentException(sprintf('The value "%s" is not available in %s', $value, static::class));
        }
        
        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public static function __callStatic(string $value, array $args = []): EnumInterface
    {
        if (!static::isValid($value)) {
            throw new \InvalidArgumentException(sprintf('The value "%s" is not available in %s', $value, static::class));
        }

        return new static($constants[$value]);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Check if the value is available as constant
     *
     * @params string $value
     *
     * @return bool
     */
    private static function isValid(string $value): bool
    {
        $self = new ReflectionClass(static::class);
        $constants = $self->getConstants();

        return array_key_exists($value, $constants));
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}

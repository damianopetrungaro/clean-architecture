<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\Common\Enum;

use InvalidArgumentException;

/**
 * The class that implement Enum should only contains constant.
 * Example:
 *
 * const ERROR_VALIDATION = 'ERROR_VALIDATION';
 * const ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';
 * const PERSISTENCE_ERROR = 'PERSISTENCE_ERROR';
 */
interface Enum
{
    /**
     * Enum constructor.
     *
     * @param mixed $value
     */
    public function __construct($value);

    /**
     * Throw an exception if there's no constant in the child class, otherwise return the constant value.
     *
     * @param string $enum
     * @param array $args
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public static function __callStatic(string $enum, array $args = []): Enum;

    /**
     * Returns the enum's allowed values.
     *
     * @return array
     */
    public static function getAllowedValues(): array;

    /**
     * Returns the enum value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Returns TRUE if it equals $enum.
     *
     * @param mixed $enum
     *
     * @return bool
     */
    public function equals($enum): bool;

    /**
     * Returns the enum value as string
     *
     * @return string
     */
    public function __toString(): string;
}

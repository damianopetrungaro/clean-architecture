<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects;


final class Surname
{
    /**
     * @var string
     */
    private $surname;

    /**
     * Surname constructor.
     *
     * @param string $surname
     */
    public function __construct(string $surname)
    {
        if (empty($surname)) {
            throw new \InvalidArgumentException("Surname can't be empty");
        }
        if (strlen($surname) > 255) {
            throw new \InvalidArgumentException("Surname '$surname' must be less than 255 chars");
        }
        $this->surname = $surname;
    }

    /**
     * Return the surname from the value object
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->surname;
    }
}
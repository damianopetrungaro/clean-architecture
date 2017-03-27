<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects;


final class Name
{
    /**
     * @var string
     */
    private $name;

    /**
     * Name constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Name can't be empty");
        }
        if (strlen($name) > 255) {
            throw new \InvalidArgumentException("Name '$name' must be less than 255 chars");
        }
        $this->name = $name;
    }

    /**
     * Return the name from the value object
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
    }
}
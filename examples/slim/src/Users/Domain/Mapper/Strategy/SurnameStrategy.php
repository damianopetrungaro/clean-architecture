<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy;


use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Surname;
use Zend\Hydrator\Strategy\StrategyInterface;

final class SurnameStrategy implements StrategyInterface
{
    /**
     * Return a string from a Surname
     *
     * @param Surname $surname
     *
     * @return string
     */
    public function extract($surname): string
    {
        if (!$surname instanceof Surname) {
            throw new \InvalidArgumentException(get_class($surname) . ' must be a Surname instance');
        }

        return $surname->getValue();
    }

    /**
     * Return a Surname from a string
     *
     * @param string $surname
     *
     * @return Surname $surname
     */
    public function hydrate($surname): Surname
    {
        return new Surname($surname);
    }
}
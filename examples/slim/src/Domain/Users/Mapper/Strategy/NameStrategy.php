<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy;


use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Name;
use Zend\Hydrator\Strategy\StrategyInterface;

final class NameStrategy implements StrategyInterface
{
    /**
     * Return a string from a Name
     *
     * @param Name $name
     *
     * @return string
     */
    public function extract($name): string
    {
        if (!$name instanceof Name) {
            throw new \InvalidArgumentException(get_class($name) . " must be a Name instance");
        }

        return $name->getValue();
    }

    /**
     * Return a Name from a string
     *
     * @param string $name
     *
     * @return Name $name
     */
    public function hydrate($name): Name
    {
        return new Name($name);
    }
}
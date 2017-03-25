<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\Strategy;


use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Password;
use Zend\Hydrator\Strategy\StrategyInterface;

final class PasswordStrategy implements StrategyInterface
{
    /**
     * Return a string from an Password
     *
     * @param Password $password
     *
     * @return string
     */
    public function extract($password): string
    {
        if (!$password instanceof Password) {
            throw new \InvalidArgumentException(get_class($password) . " must be a Password instance");
        }

        return $password->getValue();
    }

    /**
     * Return a Password from a string
     *
     * @param string $password
     *
     * @return Password $password
     */
    public function hydrate($password): Password
    {
        return Password::createFromHashedPassword($password);
    }
}
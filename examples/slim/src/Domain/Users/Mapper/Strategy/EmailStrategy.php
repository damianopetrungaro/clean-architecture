<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy;


use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Email;
use Zend\Hydrator\Strategy\StrategyInterface;

final class EmailStrategy implements StrategyInterface
{
    /**
     * Return a string from an Email
     *
     * @param Email $email
     *
     * @return string
     */
    public function extract($email): string
    {
        if (!$email instanceof Email) {
            throw new \InvalidArgumentException(get_class($email) . " must be an Email instance");
        }

        return $email->getValue();
    }

    /**
     * Return an Email from a string
     *
     * @param string $email
     *
     * @return Email $email
     */
    public function hydrate($email): Email
    {
        return new Email($email);
    }
}
<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\Strategy;


use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\UserId;
use Zend\Hydrator\Strategy\StrategyInterface;

final class UserIdStrategy implements StrategyInterface
{
    /**
     * Return a string from an UserId
     *
     * @param UserId $userId
     *
     * @return string
     */
    public function extract($userId): string
    {
        if (!$userId instanceof UserId) {
            throw new \InvalidArgumentException(get_class($userId) . " must be an UserId instance");
        }

        return $userId->getValue();
    }

    /**
     * Return an UserId from a string
     *
     * @param string $userId
     *
     * @return UserId $userId
     */
    public function hydrate($userId): UserId
    {
        return UserId::createFromString($userId);
    }
}
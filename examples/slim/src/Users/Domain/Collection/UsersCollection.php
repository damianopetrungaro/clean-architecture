<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Collection;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\Common\Collection\CollectionInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;

/**
 * @property UserEntity[] $items
 * @method UsersCollection clear() : UsersCollection
 * @method UsersCollection with($item, $key = null) : UsersCollection
 * @method UsersCollection without($key) : UsersCollection
 */
final class UsersCollection extends Collection
{
    /**
     * UsersCollection constructor.
     * @param array $users
     */
    public function __construct(array $users = [])
    {
        foreach ($users as $user) {
            if (!$user instanceof UserEntity) {
                throw new \InvalidArgumentException("User $user must be an instance of UserEntity");
            }
        }

        parent::__construct($users);
    }

    /**
     * Override for check UserEntity instance
     * PHP 7.1 haven't generic types
     * {@inheritDoc}
     *
     * @return UsersCollection
     */
    public function mergeWith(CollectionInterface...$users) : CollectionInterface
    {
        $clone = clone $this;
        foreach ($users as $user) {
            if (!$user instanceof UsersCollection) {
                throw new \InvalidArgumentException(get_class($user) . " must be an instance of UsersCollection");
            }
            $clone->items = array_merge($clone->all(), $user->all());
        }

        return $clone;
    }
}
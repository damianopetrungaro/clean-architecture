<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Collection;

use Damianopetrungaro\CleanArchitecture\Common\Collection\ArrayCollection;
use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;

/**
 * @property UserEntity[] $items
 * @method UsersArrayCollection clear() : UsersArrayCollection
 * @method UsersArrayCollection with($key, $value) : UsersArrayCollection
 * @method UsersArrayCollection without($key) : UsersArrayCollection
 */
final class UsersArrayCollection extends ArrayCollection
{
    /**
     * UsersArrayCollection constructor.
     *
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
     * @return UsersArrayCollection
     */
    public function mergeWith(Collection...$users): Collection
    {
        $clone = clone $this;
        foreach ($users as $user) {
            if (!$user instanceof UsersArrayCollection) {
                throw new \InvalidArgumentException(get_class($user) . " must be an instance of UsersArrayCollection");
            }
            $clone->items = array_merge($clone->all(), $user->all());
        }

        return $clone;
    }
}
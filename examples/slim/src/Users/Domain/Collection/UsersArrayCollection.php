<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Collection;

use Damianopetrungaro\CleanArchitecture\Common\Collection\ArrayCollection;
use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;
use InvalidArgumentException;

final class UsersArrayCollection extends ArrayCollection
{
    /**
     * UsersArrayCollection constructor.
     *
     * @param UserEntity[]|array $users
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $users = [])
    {
        foreach ($users as $user) {
            if (!$user instanceof UserEntity) {
                throw new InvalidArgumentException("User $user must be an instance of UserEntity");
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
     * @throws InvalidArgumentException
     */
    public function mergeWith(Collection...$users): Collection
    {
        foreach ($users as $user) {
            if (!$user instanceof UsersArrayCollection) {
                throw new InvalidArgumentException(get_class($user) . ' must be an instance of UsersArrayCollection');
            }
        }

        return parent::mergeWith($users);
    }
}
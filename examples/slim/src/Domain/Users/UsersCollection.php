<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity\UserEntityInterface;

final class UsersCollection extends Collection
{
    /**
     * UsersCollection constructor.
     * @param array $users
     */
    public function __construct(array $users)
    {
        foreach ($users as $user) {
            if (!$user instanceof UserEntityInterface) {
                throw new \InvalidArgumentException("User $user must be an instance of UserEntityInterface");
            }
        }

        parent::__construct($users);
    }
}
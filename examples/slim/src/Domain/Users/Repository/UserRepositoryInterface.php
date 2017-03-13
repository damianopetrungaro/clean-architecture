<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository;

use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Collection\UsersCollection;

interface UserRepositoryInterface
{
    /**
     * Return a collection of UserEntity
     *
     * @return UsersCollection
     */
    public function all(): UsersCollection;
}
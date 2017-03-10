<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository;

use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UsersCollection;

interface UserRepositoryInterface
{
    public function all(): UsersCollection;
}
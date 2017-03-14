<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository;

use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Collection\UsersCollection;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\UserId;

interface UserRepositoryInterface
{
    /**
     * Return a collection of all the Users saved to persistence
     *
     * @return UsersCollection
     *
     * @throws UserPersistenceException
     */
    public function all(): UsersCollection;

    /**
     * Return a User by UserId
     *
     * @param UserId $userId
     *
     * @return UserEntity
     *
     * @throws UserNotFoundException
     * @throws UserPersistenceException
     */
    public function getByUserId(UserId $userId): UserEntity;

    /**
     * Add a new User
     *
     * @param UserEntity $user
     *
     * @return void
     *
     * @throws UserPersistenceException
     */
    public function add(UserEntity $user): void;

    /**
     * Return next valid UserId
     *
     * @return UserId
     *
     * @throws UserPersistenceException
     */
    public function nextId(): UserId;
}
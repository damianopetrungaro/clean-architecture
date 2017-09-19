<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository;

use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Collection\UsersArrayCollection;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\UserId;

interface UserRepositoryInterface
{
    /**
     * Return a collection of all the Users saved to persistence
     *
     * @return UsersArrayCollection
     *
     * @throws UserPersistenceException
     */
    public function all(): UsersArrayCollection;

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

    /**
     * Return true or false if exists user by UserId
     *
     * @param UserId $userId
     *
     * @return bool
     *
     * @throws UserPersistenceException
     */
    public function findByUserId(UserId $userId): bool;

    /**
     * Delete User by UserId
     *
     * @param UserId $userId
     *
     * @return void
     *
     * @throws UserPersistenceException
     */
    public function deleteByUserId(UserId $userId): void;

    /**
     * Update user
     *
     * @param UserEntity $user
     *
     * @return void
     *
     * @throws UserPersistenceException
     */
    public function update(UserEntity $user): void;
}
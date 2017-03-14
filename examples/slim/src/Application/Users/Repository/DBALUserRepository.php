<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Users\Repository;

use Damianopetrungaro\CleanArchitecture\Mapper\MapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Collection\UsersCollection;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\UserId;
use Doctrine\DBAL\Connection;

/**
 * @method clear()
 * @method mergeWith()
 * @method with()
 * @method without()
 */
final class DBALUserRepository implements UserRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var MapperInterface
     */
    private $mapper;
    /**
     * @var string
     */
    private $userTable;

    /**
     * DBALUserRepository constructor.
     * @param string $userTable
     * @param Connection $connection
     * @param UserMapperInterface $mapper
     */
    public function __construct(Connection $connection, UserMapperInterface $mapper, string $userTable)
    {
        $this->connection = $connection;
        $this->mapper = $mapper;
        $this->userTable = $userTable;
    }

    /**
     * Return a collection of all the Users saved to persistence
     *
     * @return UsersCollection
     *
     * @throws UserPersistenceException
     */
    public function all(): UsersCollection
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM {$this->userTable}");
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new UserPersistenceException('impossible_get_users', $e->getCode(), $e);
        }

        return $this->mapper->toMultipleObject(UserEntity::class, $rows);
    }

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
    public function getByUserId(UserId $userId): UserEntity
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM {$this->userTable} WHERE id = :id");
            $stmt->bindParam(':id', $userId->getValue());
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new UserPersistenceException('impossible_get_user', $e->getCode(), $e);
        }

        var_dump($row);die();
        if (!$row) {
            throw new UserNotFoundException();
        }

        return $this->mapper->toObject(UserEntity::class, $row);
    }
}
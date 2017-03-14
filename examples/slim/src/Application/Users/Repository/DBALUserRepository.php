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
use Ramsey\Uuid\Uuid;

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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getByUserId(UserId $userId): UserEntity
    {
        try {
            $userId = $userId->getValue();
            $stmt = $this->connection->prepare("SELECT * FROM {$this->userTable} WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new UserPersistenceException('impossible_get_user', $e->getCode(), $e);
        }

        if (!$row) {
            throw new UserNotFoundException();
        }

        return $this->mapper->toObject(UserEntity::class, $row);
    }

    /**
     * {@inheritdoc}
     */
    public function add(UserEntity $user): void
    {
        $user = $this->mapper->toArray($user);

        try {
            $stmt = $this->connection->prepare("INSERT INTO {$this->userTable} (id, name, surname, email, password) VALUES (:id, :name, :surname, :email, :password)");
            $stmt->bindParam(':id', $user['id']);
            $stmt->bindParam(':name', $user['name']);
            $stmt->bindParam(':surname', $user['surname']);
            $stmt->bindParam(':email', $user['email']);
            $stmt->bindParam(':password', $user['password']);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new UserPersistenceException('impossible_add_user', $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function nextId(): UserId
    {
        return new UserId(Uuid::uuid1());
    }
}
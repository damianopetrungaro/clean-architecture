<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Users\Repository;

use Damianopetrungaro\CleanArchitecture\Mapper\MapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Collection\UsersCollection;
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
     */
    public function all(): UsersCollection
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->userTable}");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->mapper->toMultipleObject(UserEntity::class, $rows);
    }
}
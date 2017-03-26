<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper;


use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Collection\UsersCollection;
use Zend\Hydrator\Reflection as Hydrator;

final class UserMapper implements UserMapperInterface
{
    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * UserMapper constructor.
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritdoc}
     */
    public function toMultipleArray(UsersCollection $collection) : array
    {
        $users = [];
        /** @var UserEntity $user */
        foreach ($collection->getIterator() as $user) {
            $users[] = $this->toArray($user);
        }

        return $users;
    }

    /**
     * {@inheritdoc}
     */
    public function toMultipleObject($class, array $array): UsersCollection
    {
        $users = [];
        foreach ($array as $user) {
            $users[] = $this->toObject($class, $user);
        }

        return new UsersCollection($users);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($object) : array
    {
        return $this->hydrator->extract($object);
    }

    /**
     * {@inheritdoc}
     */
    public function toObject($class, array $array): UserEntity
    {
        $user = unserialize(sprintf('O:%u:"%s":0:{}', strlen($class), $class));
        return $this->hydrator->hydrate($array, $user);
    }
}
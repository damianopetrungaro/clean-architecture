<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper;


use Damianopetrungaro\CleanArchitecture\Mapper\MapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Collection\UsersCollection;

interface UserMapperInterface extends MapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function toArray($object) : array;

    /**
     * {@inheritdoc}
     */
    public function toObject($class, array $array): UserEntity;

    /**
     * Return an array with multiple user's array
     *
     * @param UsersCollection $collection
     *
     * @return array
     */
    public function toMultipleArray(UsersCollection $collection) : array;

    /**
     * Return an UsersCollection from an array of data
     *
     * @param $class
     * @param array $array
     *
     * @return UsersCollection
     */
    public function toMultipleObject($class, array $array) : UsersCollection;
}
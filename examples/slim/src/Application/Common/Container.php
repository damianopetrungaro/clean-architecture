<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request\AddUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request\GetUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request\ListUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Transformer\UserTransformerInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\AddUserUseCase;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\GetUserUseCase;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\ListUsersUseCase;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

final class Container extends \Slim\Container
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);
    }

    /**
     * @return Connection
     */
    public function getDatabaseConnection(): Connection
    {
        return $this->get('app.connection');
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->get('app.logger');
    }

    /**
     * @return ResponseInterface
     */
    public function getDomainResponse(): ResponseInterface
    {
        return $this->get('domain.response');
    }

    /**
     * @return ListUsersUseCase
     */
    public function getListUsersUseCase(): ListUsersUseCase
    {
        return $this->get('domain.users.useCase.listUsers');
    }

    /**
     * @return GetUserUseCase
     */
    public function getGetUserUseCase(): GetUserUseCase
    {
        return $this->get('domain.users.useCase.getUsers');
    }

    /**
     * @return AddUserUseCase
     */
    public function getAddUserUseCase(): AddUserUseCase
    {
        return $this->get('domain.users.useCase.addUser');
    }

    /**
     * @return AddUserRequest
     */
    public function getAddUserRequest(): AddUserRequest
    {
        return $this->get('app.users.request.addUser');
    }

    /**
     * @return UserRepositoryInterface
     */
    public function getUserRepository(): UserRepositoryInterface
    {
        return $this->get('domain.users.repository');
    }

    /**
     * @return ListUserRequest
     */
    public function getListUserRequest(): ListUserRequest
    {
        return $this->get('app.users.request.listUser');
    }

    /**
     * @return SlimResponseBuilder
     */
    public function getSlimResponseBuilder(): SlimResponseBuilder
    {
        return $this->get('app.response.slim');
    }

    /**
     * @return UserMapperInterface
     */
    public function getUserMapper(): UserMapperInterface
    {
        return $this->get('app.users.mapper');
    }

    /**
     * @return UserTransformerInterface
     */
    public function getUserTransformer(): UserTransformerInterface
    {
        return $this->get('app.users.transformer');
    }

    /**
     * @return GetUserRequest
     */
    public function getGetUserRequest(): GetUserRequest
    {
        return $this->get('app.users.request.getUser');
    }
}
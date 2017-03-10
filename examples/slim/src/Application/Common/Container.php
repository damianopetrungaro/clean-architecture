<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request\ListUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\ListUsersUseCase;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

final class Container extends \Slim\Container
{
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
        return $this->get('app.users.request.lisUser');
    }
}
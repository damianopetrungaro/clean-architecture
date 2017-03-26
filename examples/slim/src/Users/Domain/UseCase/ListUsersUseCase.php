<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\UseCaseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;

final class ListUsersUseCase implements UseCaseInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserMapperInterface
     */
    private $userMapper;

    /**
     * ListUsersUseCase constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserMapperInterface $userMapper
     */
    public function __construct(UserRepositoryInterface $userRepository, UserMapperInterface $userMapper)
    {
        $this->userRepository = $userRepository;
        $this->userMapper = $userMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): void
    {
        try {
            // Get Users from repository
            $userCollection = $this->userRepository->all();
        } catch (UserPersistenceException $e) {
            // If there's an error on getting set response as failed, add the error and return
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR()));
            return;
        }

        // Transform UsersCollection instances into array
        // Set the response as success, add the users to the response and return
        $users = $this->userMapper->toMultipleArray($userCollection);
        $response->addData('users', $users);
        $response->setAsSuccess();
        return;
    }
}

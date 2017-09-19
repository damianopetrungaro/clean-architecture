<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitecture\UseCase\UseCase;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorFactory;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapper;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;

final class ListUsersUseCase implements UseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserMapper
     */
    private $userMapper;
    /**
     * @var ApplicationErrorFactory
     */
    private $applicationErrorFactory;

    /**
     * ListUsersUseCase constructor.
     *
     * @param ApplicationErrorFactory $applicationErrorFactory
     * @param UserRepositoryInterface $userRepository
     * @param UserMapper $userMapper
     */
    public function __construct(ApplicationErrorFactory $applicationErrorFactory, UserRepositoryInterface $userRepository, UserMapper $userMapper)
    {
        $this->applicationErrorFactory = $applicationErrorFactory;
        $this->userRepository = $userRepository;
        $this->userMapper = $userMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response): void
    {
        try {
            // Get Users from repository
            $userCollection = $this->userRepository->all();
        } catch (UserPersistenceException $e) {
            // If there's an error on getting set response as failed, add the error and return
            $response->setAsFailed();
            $response->replaceError('generic', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR));
            return;
        }

        // Transform UsersArrayCollection instances into array
        // Set the response as success, add the users to the response and return
        $users = $this->userMapper->toMultipleArray($userCollection);
        $response->replaceData('users', $users);
        $response->setAsSuccess();
        return;
    }
}

<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\UseCaseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Transformer\UserTransformerInterface;

final class ListUsersUseCase implements UseCaseInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserTransformerInterface
     */
    private $userTransformer;
    /**
     * @var UserMapperInterface
     */
    private $userMapper;

    /**
     * ListUsersUseCase constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserTransformerInterface $userTransformer
     * @param UserMapperInterface $userMapper
     */
    public function __construct(UserRepositoryInterface $userRepository, UserTransformerInterface $userTransformer, UserMapperInterface $userMapper)
    {
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
        $this->userMapper = $userMapper;
    }

    /**
     * Method to call for initialize the use case.
     * You must use a reference to ResponseInterface to return the response.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): void
    {

        try {
            $userCollection = $this->userRepository->all();
        } catch (UserPersistenceException $e) {
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError('error_listing_users', ApplicationErrorType::PERSISTENCE_ERROR()));
            return;
        }

        $users = $this->userTransformer->mapMultiple($this->userMapper->toMultipleArray($userCollection));
        $response->addData('users', $users);
        $response->setAsSuccess();
        return;
    }
}

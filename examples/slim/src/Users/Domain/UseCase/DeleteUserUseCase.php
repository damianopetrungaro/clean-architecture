<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCaseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\UserId;

final class DeleteUserUseCase implements ValidableUseCaseInterface
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
        // If request is not valid set response as failed and return
        if (!$this->isValid($request, $response)) {
            $response->setAsFailed();
            return;
        }

        // Create UserId for check if User exists
        $userId = UserId::createFromString($request->get('id', ''));

        try {

            // If user is not found set response as failed, add the error and return
            if (!$this->userRepository->findByUserId($userId)) {
                $response->setAsFailed();
                $response->addError('generic', new ApplicationError('user_not_found', ApplicationErrorType::NOT_FOUND_ENTITY()));
                return;
            }
            // Delete user using the UserId
            $this->userRepository->deleteByUserId($userId);
        } catch (UserPersistenceException $e) {
            // If there's an error on deleting set response as failed, add the error and return
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR()));
            return;
        }

        // Set the response as success and return
        $response->setAsSuccess();
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(RequestInterface $request, ResponseInterface $response) : bool
    {
        try {
            UserId::createFromString($request->get('id', ''));
        } catch (\InvalidArgumentException $e) {
            $response->addError('generics', new ApplicationError($e->getMessage(), ApplicationErrorType::NOT_FOUND_ENTITY()));
        }

        return !$response->hasErrors();
    }
}

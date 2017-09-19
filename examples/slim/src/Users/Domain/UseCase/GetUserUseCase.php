<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCase;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorFactory;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapper;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\UserId;

final class GetUserUseCase implements ValidableUseCase
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
        // If request is not valid set response as failed and return
        if (!$this->isValid($request, $response)) {
            $response->setAsFailed();
            return;
        }

        // Create UserId for check if User exists
        $userId = $this->createUserId($request);

        try {
            // Get user by UserId
            $user = $this->userRepository->getByUserId($userId);
        } catch (UserPersistenceException $e) {
            // If User is not found set response as failed, add the error and return
            $response->setAsFailed();
            $response->replaceError('generic', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR));
            return;
        } catch (UserNotFoundException $e) {
            // If there's an error on getting set response as failed, add the error and return
            $response->setAsFailed();
            $response->replaceError('generic', $this->applicationErrorFactory->build('user_not_found', ApplicationErrorType::NOT_FOUND_ENTITY));
            return;
        }

        // Transform User instances into array
        // Set the response as success, add the user to the response and return
        $user = $this->userMapper->toArray($user);
        $response->replaceData('user', $user);
        $response->setAsSuccess();
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(Request $request, Response $response) : bool
    {
        try {
            $userId = $this->createUserId($request);
            unset($userId);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('generics', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::NOT_FOUND_ENTITY));
        }

        return !$response->hasErrors();
    }

    /**
     * Create a UserId using a string
     * Extracted for better testability
     *
     * @param Request $request
     *
     * @return UserId
     */
    private function createUserId(Request $request): UserId
    {
        return UserId::createFromString($request->get('id', ''));
    }
}

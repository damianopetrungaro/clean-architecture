<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCase;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorFactory;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapper;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Email;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Name;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Password;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Surname;

final class AddUserUseCase implements ValidableUseCase
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

        // Create user
        $user = $this->createUser($request);

        try {
            // Add User to repository
            $this->userRepository->add($user);
        } catch (UserPersistenceException $e) {
            // If there's an error on saving set response as failed, add the error and return
            $response->setAsFailed();
            $response->replaceError('generic', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR));
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
            $name = new Name($request->get('name', ''));
            unset($name);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('name', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR));
        }

        try {
            $surname = new Surname($request->get('surname', ''));
            unset($surname);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('surname', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR));
        }

        try {
            $email = new Email($request->get('email', ''));
            unset($email);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('email', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR));
        }

        try {
            $password = new Password($request->get('password', ''));
            unset($password);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('password', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR));
        }

        return !$response->hasErrors();
    }

    /**
     * Create a new User
     * Extracted as method for better testability
     *
     * @param Request $request
     *
     * @return UserEntity
     */
    private function createUser(Request $request): UserEntity
    {
        // Create new User using valueObjects
        return new UserEntity(
            $this->userRepository->nextId(),
            new Name($request->get('name')),
            new Surname($request->get('surname')),
            new Email($request->get('email')),
            new Password($request->get('password'))
        );
    }
}

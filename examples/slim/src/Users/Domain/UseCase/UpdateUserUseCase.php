<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCase;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorFactory;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapper;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Email;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Name;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Password;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Surname;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\UserId;

final class UpdateUserUseCase implements ValidableUseCase
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

            // Before update the user check that the old_password match the old one
            if (!$user->password()->checkValidity($request->get('old_password'))) {
                $response->setAsFailed();
                $response->replaceError('generic', $this->applicationErrorFactory->build('password_mismatch', ApplicationErrorType::USER_PASSWORD_MISMATCH));

                return;
            }

            // Update the User using valueObjects
            $this->updateUser($request, $user);

            // Update User to the repository
            $this->userRepository->update($user);
        } catch (UserNotFoundException $e) {
            // If User is not found set response as failed, add the error and return
            $response->setAsFailed();
            $response->replaceError('generic', $this->applicationErrorFactory->build('user_not_found', ApplicationErrorType::NOT_FOUND_ENTITY));

            return;
        } catch (UserPersistenceException $e) {
            // If there's an error on updating set response as failed, add the error and return
            $response->setAsFailed();
            $response->replaceError('generic', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR));

            return;
        }

        // Transform User instances into array
        // Set the response as success, add the user to the response and return
        $user = $this->userMapper->toArray($user);
        $response->replaceData('user', $user);
        $response->setAsSuccess();
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(Request $request, Response $response): bool
    {
        try {
            $userId = $this->createUserId($request);
            unset($userId);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('generics', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::NOT_FOUND_ENTITY));
        }

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
            $password = new Password($request->get('old_password', ''));
            unset($password);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('old_password', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR));
        }

        try {
            $password = new Password($request->get('new_password', ''));
            unset($password);
        } catch (\InvalidArgumentException $e) {
            $response->replaceError('new_password', $this->applicationErrorFactory->build($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR));
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

    /**
     * Update User info
     * Extracted for better testability
     *
     * @param Request $request
     * @param $user
     *
     * @return void
     */
    private function updateUser(Request $request, UserEntity $user): void
    {
        $user->update(
            new Name($request->get('name')),
            new Surname($request->get('surname')),
            new Email($request->get('email')),
            new Password($request->get('new_password'))
        );
    }
}

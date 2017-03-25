<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCaseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\Transformer\UserTransformerInterface;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Email;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Name;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Password;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\Surname;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\ValueObjects\UserId;

final class UpdateUserUseCase implements ValidableUseCaseInterface
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
        if (!$this->isValid($request, $response)) {
            $response->setAsFailed();
            return;
        }

        $userId = UserId::createFromString($request->get('id', ''));

        try {
            $user = $this->userRepository->getByUserId($userId);

            // Before update the user check that the old_password match the old one
            if (!$user->password()->checkValidity($request->get('old_password'))) {
                $response->setAsFailed();
                $response->addError('generic', new ApplicationError('password_mismatch', ApplicationErrorType::USER_PASSWORD_MISMATCH()));
                return;
            }

            $user->update(
                new Name($request->get('name')),
                new Surname($request->get('surname')),
                new Email($request->get('email')),
                new Password($request->get('new_password'))
            );
            $this->userRepository->update($user);
        } catch (UserNotFoundException $e) {
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError('user_not_found', ApplicationErrorType::NOT_FOUND_ENTITY()));
            return;
        } catch (UserPersistenceException $e) {
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR()));
            return;
        }

        $user = $this->userTransformer->map($this->userMapper->toArray($user));
        $response->addData('user', $user);
        $response->setAsSuccess();
        return;
    }

    /**
     * Method to call for validate an UseCase.
     * You must use a reference to ResponseInterface to add errors to response.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return bool
     */
    public function isValid(RequestInterface $request, ResponseInterface $response) : bool
    {
        try {
            UserId::createFromString($request->get('id', ''));
        } catch (\InvalidArgumentException $e) {
            $response->addError('generics', new ApplicationError($e->getMessage(), ApplicationErrorType::NOT_FOUND_ENTITY()));
        }

        try {
            $name = new Name($request->get('name', ''));
            unset($name);
        } catch (\InvalidArgumentException $e) {
            $response->addError('name', new ApplicationError($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR()));
        }

        try {
            $surname = new Surname($request->get('surname', ''));
            unset($surname);
        } catch (\InvalidArgumentException $e) {
            $response->addError('surname', new ApplicationError($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR()));
        }

        try {
            $email = new Email($request->get('email', ''));
            unset($email);
        } catch (\InvalidArgumentException $e) {
            $response->addError('email', new ApplicationError($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR()));
        }

        try {
            $password = new Password($request->get('old_password', ''));
            unset($password);
        } catch (\InvalidArgumentException $e) {
            $response->addError('old_password', new ApplicationError($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR()));
        }

        try {
            $password = new Password($request->get('new_password', ''));
            unset($password);
        } catch (\InvalidArgumentException $e) {
            $response->addError('new_password', new ApplicationError($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR()));
        }

        return !$response->hasErrors();
    }
}

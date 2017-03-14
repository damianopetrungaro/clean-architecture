<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCaseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Entity\UserEntity;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Transformer\UserTransformerInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Email;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Name;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Password;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\Surname;

final class AddUserUseCase implements ValidableUseCaseInterface
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

        $user = new UserEntity(
            $this->userRepository->nextId(),
            new Name($request->get('name')),
            new Surname($request->get('surname')),
            new Email($request->get('email')),
            new Password($request->get('password'))
        );

        try {
            $this->userRepository->add($user);
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
            $password = new Password($request->get('password', ''));
            unset($password);
        } catch (\InvalidArgumentException $e) {
            $response->addError('password', new ApplicationError($e->getMessage(), ApplicationErrorType::VALIDATION_ERROR()));
        }

        return !$response->hasErrors();
    }
}

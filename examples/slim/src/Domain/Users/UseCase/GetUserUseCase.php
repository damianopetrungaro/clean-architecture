<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Validation\ValidableUseCaseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationErrorType;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Mapper\UserMapperInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserNotFoundException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\Exception\UserPersistenceException;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Repository\UserRepositoryInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\Transformer\UserTransformerInterface;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\ValueObjects\UserId;

final class GetUserUseCase implements ValidableUseCaseInterface
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

        try {
            $user = $this->userRepository->getByUserId(
                UserId::createFromString($request->get('id'))
            );
        } catch (UserPersistenceException $e) {
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError($e->getMessage(), ApplicationErrorType::PERSISTENCE_ERROR()));
            return;
        } catch (UserNotFoundException $e) {
            $response->setAsFailed();
            $response->addError('generic', new ApplicationError($e->getMessage(), ApplicationErrorType::NOT_FOUND_ENTITY()));
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
            UserId::createFromString($request->get('id'));
        } catch (\InvalidArgumentException $e) {
            $response->addError('generic', new ApplicationError('user_not_found', ApplicationErrorType::NOT_FOUND_ENTITY()));
        }

        return !$response->hasErrors();
    }
}

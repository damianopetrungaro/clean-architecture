<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Users\Controller;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request\AddUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\AddUserUseCase;
use Slim\Http\Request;
use Slim\Http\Response;

final class AddUserController
{
    /**
     * @var AddUserUseCase
     */
    private $useCase;
    /**
     * @var ResponseInterface
     */
    private $domainResponse;
    /**
     * @var AddUserRequest
     */
    private $domainRequest;
    /**
     * @var SlimResponseBuilder
     */
    private $slimResponseBuilder;

    /**
     * ListUsersController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->useCase = $container->getAddUserUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->domainRequest = $container->getAddUserRequest();
        $this->slimResponseBuilder = $container->getSlimResponseBuilder();
    }

    /**
     * Controller for AddUserUseCase
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $this->useCase->__invoke($this->domainRequest->build($request), $this->domainResponse);
        return $this->slimResponseBuilder->build($this->domainResponse);
    }
}
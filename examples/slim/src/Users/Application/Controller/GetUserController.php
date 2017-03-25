<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Users\Application\Request\GetUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\GetUserUseCase;
use Slim\Http\Request;
use Slim\Http\Response;

final class GetUserController
{
    /**
     * @var GetUserUseCase
     */
    private $useCase;
    /**
     * @var ResponseInterface
     */
    private $domainResponse;
    /**
     * @var GetUserRequest
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
        $this->useCase = $container->getGetUserUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->domainRequest = $container->getGetUserRequest();
        $this->slimResponseBuilder = $container->getSlimResponseBuilder();
    }

    /**
     * Controller for GetUserUseCase
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
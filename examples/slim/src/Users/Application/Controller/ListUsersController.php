<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Users\Application\Request\ListUserRequest;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\ListUsersUseCase;
use Slim\Http\Request;
use Slim\Http\Response;

final class ListUsersController
{
    /**
     * @var ListUsersUseCase
     */
    private $useCase;
    /**
     * @var ResponseInterface
     */
    private $domainResponse;
    /**
     * @var ListUserRequest
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
        $this->useCase = $container->getListUsersUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->domainRequest = $container->getListUserRequest();
        $this->slimResponseBuilder = $container->getSlimResponseBuilder();
    }

    /**
     * Controller for ListUsersUseCase
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
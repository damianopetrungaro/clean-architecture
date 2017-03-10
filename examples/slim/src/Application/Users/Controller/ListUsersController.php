<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Users\Controller;

use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Domain\Users\UseCase\ListUsersUseCase;
use Slim\Http\Request;
use Slim\Http\Response;

final class ListUsersController
{
    /**
     * @var ListUsersUseCase
     */
    private $useCase;

    /**
     * ListUsersController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->useCase = $container->getListUsersUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->domainRequest = $container->getListUserRequest();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $this->useCase->__invoke($this->domainRequest->build($request), $this->domainResponse);
    }
}
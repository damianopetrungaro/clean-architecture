<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller;

use Damianopetrungaro\CleanArchitecture\Common\Collection\ArrayCollection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\CollectionRequest as DomainRequest;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitectureSlim\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Users\Application\Transformer\UserTransformer;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\ListUsersUseCase;
use Slim\Http\Request;
use Slim\Http\Response as SlimResponse;

final class ListUsersController
{
    /**
     * @var ListUsersUseCase
     */
    private $useCase;
    /**
     * @var Response
     */
    private $domainResponse;
    /**
     * @var SlimResponseBuilder
     */
    private $slimResponseBuilder;
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * ListUsersController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->useCase = $container->getListUsersUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->userTransformer = $container->getUserTransformer();
        $this->slimResponseBuilder = $container->getSlimResponseBuilder();
    }

    /**
     * Controller for ListUsersUseCase
     *
     * @param Request $request
     *
     * @return SlimResponse
     */
    public function __invoke(Request $request): SlimResponse
    {
        // Invoke the UseCase and use the domainResponse reference for build a response
        $this->useCase->__invoke($this->createRequest(), $this->domainResponse);

        // Get the data from the response
        $data = $this->domainResponse->getData();

        // If the response has a data key, transform it, and override it in the response
        if (isset($data['users'])) {
            $users = $this->userTransformer->mapMultiple($data['users']);
            $this->domainResponse->replaceData('users', $users);
        }

        return $this->slimResponseBuilder->build($this->domainResponse);
    }

    /**
     * Create the specific DomainRequest
     *
     * @return DomainRequest
     */
    private function createRequest(): DomainRequest
    {
        // The request for this useCase doesn't need of any data
        return new DomainRequest(new ArrayCollection());
    }
}
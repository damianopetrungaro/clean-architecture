<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller;

use Damianopetrungaro\CleanArchitecture\Common\Collection\ArrayCollection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\CollectionRequest as DomainRequest;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitectureSlim\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Users\Application\Transformer\UserTransformer;
use Damianopetrungaro\CleanArchitectureSlim\Users\Domain\UseCase\DeleteUserUseCase;
use Slim\Http\Request;
use Slim\Http\Response as SlimResponse;

final class DeleteUserController
{
    /**
     * @var DeleteUserUseCase
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
     * DeleteUserController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->useCase = $container->getDeleteUserUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->userTransformer = $container->getUserTransformer();
        $this->slimResponseBuilder = $container->getSlimResponseBuilder();
    }

    /**
     * Controller for DeleteUserUseCase
     *
     * @param Request $request
     *
     * @return SlimResponse
     */
    public function __invoke(Request $request): SlimResponse
    {
        // Invoke the UseCase and use the domainResponse reference for build a response
        $this->useCase->__invoke($this->createRequest($request), $this->domainResponse);

        return $this->slimResponseBuilder->build($this->domainResponse);
    }

    /**
     * Create the specific DomainRequest
     *
     * @param Request $request
     *
     * @return DomainRequest
     */
    private function createRequest(Request $request): DomainRequest
    {
        // The request for this useCase requires only the id
        $entries = ['id' => $request->getAttribute('id')];

        return new DomainRequest(new ArrayCollection($entries));
    }
}
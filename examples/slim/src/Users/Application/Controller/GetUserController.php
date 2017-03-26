<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Controller;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request as DomainRequest;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Container;
use Damianopetrungaro\CleanArchitectureSlim\Common\Response\SlimResponseBuilder;
use Damianopetrungaro\CleanArchitectureSlim\Users\Application\Transformer\UserTransformer;
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
     * @var SlimResponseBuilder
     */
    private $slimResponseBuilder;
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * ListUsersController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->useCase = $container->getGetUserUseCase();
        $this->domainResponse = $container->getDomainResponse();
        $this->userTransformer = $container->getUserTransformer();
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
    public function __invoke(Request $request, Response $response, $args): Response
    {
        // Invoke the UseCase and use the domainResponse reference for build a response
        $this->useCase->__invoke($this->createRequest($request), $this->domainResponse);

        // Get the data from the response
        $data = $this->domainResponse->getData();

        // If the response has a data key, transform it, and override it in the response
        if (isset($data['user'])) {
            $user = $this->userTransformer->mapMultiple(reset($data['user']));
            $this->domainResponse->removeData('user');
            $this->domainResponse->addData('user', $user);
        }

        return $this->slimResponseBuilder->build($this->domainResponse);
    }

    /**
     * Create the specific DomainRequest
     *
     * @param Request $request
     * @return DomainRequest
     */
    private function createRequest(Request $request): DomainRequest
    {
        // The request for this useCase requires only the id
        $entries = ['id' => $request->getAttribute('id')];
        return new DomainRequest(new Collection($entries));
    }
}
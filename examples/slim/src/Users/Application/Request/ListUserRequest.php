<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Request\RequestBuilderInterface;
use Slim\Http\Request;

final class ListUserRequest implements RequestBuilderInterface
{
    public function build(Request $request): RequestInterface
    {
        // The request for this useCase dose not have any params
        return new \Damianopetrungaro\CleanArchitecture\UseCase\Request\Request(new Collection());
    }
}
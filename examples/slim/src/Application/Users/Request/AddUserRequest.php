<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Users\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Request\RequestBuilderInterface;
use Slim\Http\Request;

final class AddUserRequest implements RequestBuilderInterface
{
    public function build(Request $request): RequestInterface
    {
        $entries = $request->getParsedBody();

        // The request for this useCase requires all user info
        return new \Damianopetrungaro\CleanArchitecture\UseCase\Request\Request(new Collection($entries));
    }
}
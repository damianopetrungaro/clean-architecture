<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Request\RequestBuilderInterface;
use Slim\Http\Request;

final class UpdateUserRequest implements RequestBuilderInterface
{
    public function build(Request $request): RequestInterface
    {
        $entries = $request->getParsedBody();
        $entries['id'] = $request->getAttribute('id');

        // The request for this useCase requires all user info
        return new \Damianopetrungaro\CleanArchitecture\UseCase\Request\Request(new Collection($entries));
    }
}
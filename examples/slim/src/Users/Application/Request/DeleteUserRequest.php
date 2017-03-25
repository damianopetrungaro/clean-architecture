<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Users\Application\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Request\RequestBuilderInterface;
use Slim\Http\Request;

final class DeleteUserRequest implements RequestBuilderInterface
{
    public function build(Request $request): RequestInterface
    {
        $entries = [
            'id' => $request->getAttribute('id')
        ];

        // The request for this useCase requires the user id
        return new \Damianopetrungaro\CleanArchitecture\UseCase\Request\Request(new Collection($entries));
    }
}
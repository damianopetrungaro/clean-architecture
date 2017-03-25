<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Common\Request;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Slim\Http\Request;

interface RequestBuilderInterface
{
    public function build(Request $request): RequestInterface;
}
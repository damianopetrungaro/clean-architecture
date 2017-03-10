<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common;

use Damianopetrungaro\CleanArchitecture\UseCase\Request\RequestInterface;
use Slim\Http\Request;

interface RequestBuilderInterface
{
    public function build(Request $request): RequestInterface;
}
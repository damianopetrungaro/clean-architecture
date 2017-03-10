<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Slim\Http\Response;

interface ResponseBuilderInterface
{
    public static function build(ResponseInterface $response): Response;
}
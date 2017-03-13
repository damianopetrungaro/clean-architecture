<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;

interface ResponseBuilderInterface
{
    /**
     * Build a Response
     *
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function build(ResponseInterface $response);
}
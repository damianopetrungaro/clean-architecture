<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Common\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;

interface ResponseBuilderInterface
{
    /**
     * Build a Response
     *
     * @param Response $response
     *
     * @return mixed
     */
    public function build(Response $response);
}
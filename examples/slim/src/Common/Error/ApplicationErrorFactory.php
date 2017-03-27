<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Common\Error;


final class ApplicationErrorFactory
{
    /**
     * Create an ApplicationError
     *
     * @param $code
     * @param string $errorType
     * @param string $pointer
     * @param string $title
     * @param string $detail
     * @param array $meta
     *
     * @return ApplicationError
     */
    public function build($code, string $errorType, string $pointer = '', string $title = '', string $detail = '', array $meta = [])
    {
        return new ApplicationError($code, ApplicationErrorType::$errorType(), $pointer, $title, $detail, $meta);
    }
}
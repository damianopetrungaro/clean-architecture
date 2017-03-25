<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error;


use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorType;

/**
 * @method static ApplicationErrorType NOT_FOUND_ENTITY()
 * @method static ApplicationErrorType VALIDATION_ERROR()
 * @method static ApplicationErrorType PERSISTENCE_ERROR()
 */
class ApplicationErrorType extends ErrorType
{
    public const NOT_FOUND_ENTITY = 'NOT_FOUND_ENTITY';
    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
    public const PERSISTENCE_ERROR = 'PERSISTENCE_ERROR';
}
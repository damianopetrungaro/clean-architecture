<?php

declare(strict_types=1);

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;

use Damianopetrungaro\CleanArchitecture\Common\Enum\ReflectionEnum;

/**
 * See enum comments.
 *
 * @see \Damianopetrungaro\CleanArchitecture\Common\Enum\Enum
 */
abstract class AbstractErrorType extends ReflectionEnum implements ErrorType
{
}

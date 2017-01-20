<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Error;


use Damianopetrungaro\CleanArchitecture\Common\Enum;

abstract class ErrorType extends Enum
{
    /**
     * The class that extents ErrorType should only contains constant (an example below)
     *
     * const VALIDATION = 'VALIDATION';
     * const PERSISTENCE = 'PERSISTENCE';
     * const ENTITY_NOT_FOUND= 'ENTITY_NOT_FOUND';
     */
}
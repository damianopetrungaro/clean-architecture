<?php

namespace Damianopetrungaro\CleanArchitecture\UseCase\Response;


use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;

interface ResponseInterface
{
    public function addData($key, $value) : void;

    public function addError($key, Error $error) : void;

    public function getData() : array;

    public function getError() : array;

    public function hasData() : bool;

    public function hasError() : bool;

    public function isFailed() : bool;

    public function isSuccessful() : bool;

    public function setAsFailed() : void;

    public function setAsSuccess() : void;
}
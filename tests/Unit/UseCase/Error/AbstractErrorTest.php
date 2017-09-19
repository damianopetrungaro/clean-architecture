<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\UseCase\Error;


use Damianopetrungaro\CleanArchitecture\UseCase\Error\AbstractError;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorType;
use PHPUnit\Framework\TestCase;

class AbstractErrorTest extends TestCase
{
    /**
     * Test that abstract error return excepted code and type
     *
     * @param $code
     *
     * @dataProvider errorCodeDataProvider
     */
    public function testAbstractError($code)
    {
        $errorType = $this->prophesize(ErrorType::class)->reveal();
        /** @var AbstractError $error */
        $error = new class($code, $errorType) extends AbstractError
        {
        };

        $this->assertEquals($code, $error->code());
        $this->assertEquals($errorType, $error->type());
    }

    /**
     * @return array
     */
    public function errorCodeDataProvider()
    {
        return [['error_code_1'], ['error_code_2'], [123]];
    }
}
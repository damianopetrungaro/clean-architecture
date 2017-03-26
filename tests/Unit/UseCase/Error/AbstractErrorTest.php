<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\UseCase\Error;


use Damianopetrungaro\CleanArchitecture\UseCase\Error\AbstractError;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorTypeInterface;

class AbstractErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that abstract error return excepted code and type
     * @param $code
     * @dataProvider testAbstractErrorDataProvider
     */
    public function testAbstractError($code)
    {
        $errorTypeMock = $this->getMockBuilder(ErrorTypeInterface::class)->getMock();
        /** @var AbstractError $error */
        $error = (new class($code, $errorTypeMock) extends AbstractError
        {
        });
        $this->assertEquals($code, $error->code());
        $this->assertEquals($errorTypeMock, $error->type());
    }

    /**
     * @return array
     */
    public function testAbstractErrorDataProvider()
    {
        return [['error_code_1'], ['error_code_2'], [123]];
    }
}
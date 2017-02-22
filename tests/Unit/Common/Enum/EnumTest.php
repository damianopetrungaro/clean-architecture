<?php
namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum;

use Damianopetrungaro\CleanArchitecture\Common\Enum\Enum;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check that an InvalidArgumentException is thrown
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        Enum::NOT_EXISTS();
    }

    /**
     * Check that the call static method return the expected value
     *
     */
    public function testValidEnum()
    {
        $extendedEnum = new class extends Enum
        {
            protected const CONSTANT_NAME = 'this is a value';
            protected const ANOTHER_CONSTANT_NAME = 'ANOTHER_CONSTANT_NAME';
            protected const LAST_CONSTANT_NAME = 'Last!';
        };

        $this->assertEquals($extendedEnum::CONSTANT_NAME(), 'this is a value');
        $this->assertEquals($extendedEnum::ANOTHER_CONSTANT_NAME(), 'ANOTHER_CONSTANT_NAME');
        $this->assertEquals($extendedEnum::LAST_CONSTANT_NAME(), 'Last!');
    }
}
<?php
namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum;

use Damianopetrungaro\CleanArchitecture\Common\Enum\Enum;
use Damianopetrungaro\CleanArchitecture\Common\Enum\EnumInterface;
use PHPUnit\Framework\TestCase;

class MyEnum extends Enum
{
    protected const CONSTANT_NAME = 'this is a value';
    protected const ANOTHER_CONSTANT_NAME = 'ANOTHER_CONSTANT_NAME';
    protected const LAST_CONSTANT_NAME = 'Last!';
}

class EnumTest extends TestCase
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
        $firstEnum = MyEnum::CONSTANT_NAME();
        $secondEnum = MyEnum::ANOTHER_CONSTANT_NAME();
        $thirdEnum = MyEnum::LAST_CONSTANT_NAME();

        $this->assertTrue($firstEnum instanceof Enum);
        $this->assertTrue($secondEnum instanceof Enum);
        $this->assertTrue($thirdEnum instanceof Enum);

        $this->assertEquals($firstEnum->getValue(), 'this is a value');
        $this->assertEquals($secondEnum->getValue(), 'ANOTHER_CONSTANT_NAME');
        $this->assertEquals($thirdEnum->getValue(), 'Last!');
    }
}

<?php
namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum;

use Damianopetrungaro\CleanArchitecture\Common\Enum\Enum;
use Damianopetrungaro\CleanArchitecture\Common\Enum\EnumInterface;
use Damianopetrungaro\CleanArchitecture\Unit\Common\Enum\Fixtures\MyEnum;
use PHPUnit\Framework\TestCase;

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
     * Check that an InvalidArgumentException is thrown
     *
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new MyEnum('NOT_EXISTS');
    }

    /**
     * Check that the call static method return the expected value
     *
     */
    public function testValidEnumConstructor()
    {
        $firstEnum = new MyEnum(MyEnum::VALUE_A);
        $secondEnum = new MyEnum(MyEnum::VALUE_B);
        $thirdEnum = new MyEnum(MyEnum::VALUE_C);

        $this->assertTrue($firstEnum instanceof EnumInterface);
        $this->assertTrue($secondEnum instanceof EnumInterface);
        $this->assertTrue($thirdEnum instanceof EnumInterface);

        $this->assertEquals($firstEnum->getValue(), 'A');
        $this->assertEquals($secondEnum->getValue(), 'B');
        $this->assertEquals($thirdEnum->getValue(), 'C');
    }

    /**
     * Check that the call static method return the expected value
     */
    public function testValidEnumFactory()
    {
        $firstEnum = MyEnum::VALUE_A();
        $secondEnum = MyEnum::VALUE_B();
        $thirdEnum = MyEnum::VALUE_C();

        $this->assertTrue($firstEnum instanceof EnumInterface);
        $this->assertTrue($secondEnum instanceof EnumInterface);
        $this->assertTrue($thirdEnum instanceof EnumInterface);

        $this->assertEquals($firstEnum->getValue(), 'A');
        $this->assertEquals($secondEnum->getValue(), 'B');
        $this->assertEquals($thirdEnum->getValue(), 'C');
    }
}

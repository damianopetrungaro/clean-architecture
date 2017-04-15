<?php
namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum;

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
    public function testCallStaticInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        MyEnum::NOT_EXISTS();
    }

    /**
     * Check that an InvalidArgumentException is thrown using the Enum constructor
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
    public function testConstructorValidEnum()
    {
        $firstEnum = new MyEnum(MyEnum::VALUE_A);
        $secondEnum = new MyEnum(MyEnum::VALUE_B);
        $thirdEnum = new MyEnum(MyEnum::VALUE_C);

        $this->assertTrue($firstEnum instanceof EnumInterface);
        $this->assertTrue($secondEnum instanceof EnumInterface);
        $this->assertTrue($thirdEnum instanceof EnumInterface);

        $this->assertEquals($firstEnum->getValue(), 'VALUE_A');
        $this->assertEquals($secondEnum->getValue(), 'VALUE_B');
        $this->assertEquals($thirdEnum->getValue(), 'VALUE_C');
    }

    /**
     * Check that the call static method return the expected value
     */
    public function testCallStaticValidEnum()
    {
        /** @var EnumInterface $firstEnum */
        $firstEnum = MyEnum::VALUE_A();

        /** @var EnumInterface $secondEnum */
        $secondEnum = MyEnum::VALUE_B();

        /** @var EnumInterface $thirdEnum */
        $thirdEnum = MyEnum::VALUE_C();

        $this->assertTrue($firstEnum instanceof EnumInterface);
        $this->assertTrue($secondEnum instanceof EnumInterface);
        $this->assertTrue($thirdEnum instanceof EnumInterface);

        $this->assertEquals($firstEnum->getValue(), 'VALUE_A');
        $this->assertEquals($secondEnum->getValue(), 'VALUE_B');
        $this->assertEquals($thirdEnum->getValue(), 'VALUE_C');
    }

    /**
     * Check that the toString magic method return valid value
     */
    public function testToStringMagicMethod()
    {
        $enum = new MyEnum(MyEnum::VALUE_A);

        $this->assertEquals((string)$enum, MyEnum::VALUE_A);
    }
}

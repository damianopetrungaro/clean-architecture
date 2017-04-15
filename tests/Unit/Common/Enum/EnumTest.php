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
        $firstEnum = new MyEnum(MyEnum::A);
        $secondEnum = new MyEnum(MyEnum::B);
        $thirdEnum = new MyEnum(MyEnum::C);
        $fourthEnum = new MyEnum(MyEnum::VALUE_NUMB);

        $this->assertTrue($firstEnum instanceof EnumInterface);
        $this->assertTrue($secondEnum instanceof EnumInterface);
        $this->assertTrue($thirdEnum instanceof EnumInterface);
        $this->assertTrue($fourthEnum instanceof EnumInterface);

        $this->assertEquals($firstEnum->getValue(), 'VALUE_A');
        $this->assertEquals($secondEnum->getValue(), 'VALUE_B');
        $this->assertEquals($thirdEnum->getValue(), 'VALUE_C');
        $this->assertEquals($fourthEnum->getValue(), 12);
    }

    /**
     * Check that the call static method return the expected value
     */
    public function testCallStaticValidEnum()
    {
        /** @var EnumInterface $firstEnum */
        $firstEnum = MyEnum::A();

        /** @var EnumInterface $secondEnum */
        $secondEnum = MyEnum::B();

        /** @var EnumInterface $thirdEnum */
        $thirdEnum = MyEnum::C();

        /** @var EnumInterface $fourthEnum */
        $fourthEnum = MyEnum::VALUE_NUMB();

        $this->assertTrue($firstEnum instanceof EnumInterface);
        $this->assertTrue($secondEnum instanceof EnumInterface);
        $this->assertTrue($thirdEnum instanceof EnumInterface);

        $this->assertEquals($firstEnum->getValue(), 'VALUE_A');
        $this->assertEquals($secondEnum->getValue(), 'VALUE_B');
        $this->assertEquals($thirdEnum->getValue(), 'VALUE_C');
        $this->assertEquals($fourthEnum->getValue(), 12);
    }

    /**
     * Check that the toString magic method return valid value
     */
    public function testToStringMagicMethod()
    {
        $firstEnum = new MyEnum(MyEnum::A);
        $secondEnum = new MyEnum(MyEnum::VALUE_NUMB);

        $this->assertEquals((string)$firstEnum, MyEnum::A);
        $this->assertEquals((string)$secondEnum, '12');
    }
}

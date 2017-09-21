<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum;

use Damianopetrungaro\CleanArchitecture\Common\Enum\Enum;
use Damianopetrungaro\CleanArchitecture\Unit\Common\Enum\Fixtures\FixtureEnum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    /**
     * Check that an InvalidArgumentException is thrown
     */
    public function testCallStaticInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        FixtureEnum::NOT_EXISTS();
    }

    /**
     * Check that an InvalidArgumentException is thrown using the ReflectionEnum constructor
     */
    public function testConstructorInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new FixtureEnum('NOT_EXISTS');
    }

    /**
     * Check that the call static method return the expected value
     *
     */
    public function testConstructorValidEnum()
    {
        $firstEnum = new FixtureEnum(FixtureEnum::A);
        $secondEnum = new FixtureEnum(FixtureEnum::B);
        $thirdEnum = new FixtureEnum(FixtureEnum::C);
        $fourthEnum = new FixtureEnum(FixtureEnum::VALUE_NUMB);

        $this->assertInstanceOf(Enum::class, $firstEnum);
        $this->assertInstanceOf(Enum::class, $secondEnum);
        $this->assertInstanceOf(Enum::class, $thirdEnum);
        $this->assertInstanceOf(Enum::class, $fourthEnum);

        $this->assertSame($firstEnum->getValue(), 'VALUE_A');
        $this->assertSame($secondEnum->getValue(), 'VALUE_B');
        $this->assertSame($thirdEnum->getValue(), 'VALUE_C');
        $this->assertSame($fourthEnum->getValue(), 12);
    }

    /**
     * Check that the call static method return the expected value
     */
    public function testCallStaticValidEnum()
    {
        /** @var Enum $firstEnum */
        $firstEnum = FixtureEnum::A();

        /** @var Enum $secondEnum */
        $secondEnum = FixtureEnum::B();

        /** @var Enum $thirdEnum */
        $thirdEnum = FixtureEnum::C();

        /** @var Enum $fourthEnum */
        $fourthEnum = FixtureEnum::VALUE_NUMB();

        $this->assertInstanceOf(Enum::class, $firstEnum);
        $this->assertInstanceOf(Enum::class, $secondEnum);
        $this->assertInstanceOf(Enum::class, $thirdEnum);

        $this->assertSame($firstEnum->getValue(), 'VALUE_A');
        $this->assertSame($secondEnum->getValue(), 'VALUE_B');
        $this->assertSame($thirdEnum->getValue(), 'VALUE_C');
        $this->assertSame($fourthEnum->getValue(), 12);
    }

    /**
     * Check that the toString magic method return valid value
     */
    public function testToStringMagicMethod()
    {
        $firstEnum = new FixtureEnum(FixtureEnum::A);
        $secondEnum = new FixtureEnum(FixtureEnum::VALUE_NUMB);

        $this->assertSame((string)$firstEnum, FixtureEnum::A);
        $this->assertSame((string)$secondEnum, '12');
    }
}

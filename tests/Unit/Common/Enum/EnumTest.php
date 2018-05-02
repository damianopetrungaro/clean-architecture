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

        $this->assertSame('VALUE_A', $firstEnum->getValue());
        $this->assertSame('VALUE_B', $secondEnum->getValue());
        $this->assertSame('VALUE_C', $thirdEnum->getValue());
        $this->assertSame(12, $fourthEnum->getValue());
    }

    /**
     * Check that the call static method return the expected value
     */
    public function testCallStaticValidEnum()
    {
        $firstEnum = FixtureEnum::A();
        $secondEnum = FixtureEnum::B();
        $thirdEnum = FixtureEnum::C();
        $fourthEnum = FixtureEnum::VALUE_NUMB();

        $this->assertInstanceOf(Enum::class, $firstEnum);
        $this->assertInstanceOf(Enum::class, $secondEnum);
        $this->assertInstanceOf(Enum::class, $thirdEnum);
        $this->assertInstanceOf(Enum::class, $fourthEnum);

        $this->assertSame('VALUE_A', $firstEnum->getValue());
        $this->assertSame('VALUE_B', $secondEnum->getValue());
        $this->assertSame('VALUE_C', $thirdEnum->getValue());
        $this->assertSame(12, $fourthEnum->getValue());
    }

    public function testGetValues()
    {
        $expected = [
            'A' => 'VALUE_A',
            'B' => 'VALUE_B',
            'C' => 'VALUE_C',
            'VALUE_NUMB' => 12,
        ];

        $this->assertEquals($expected, FixtureEnum::getAllowedValues());
    }

    /**
     * Check that the toString magic method return valid value
     */
    public function testToStringMagicMethod()
    {
        $firstEnum = new FixtureEnum(FixtureEnum::A);
        $secondEnum = new FixtureEnum(FixtureEnum::VALUE_NUMB);

        $this->assertSame('VALUE_A', (string) $firstEnum);
        $this->assertSame('12', (string) $secondEnum);
    }
}

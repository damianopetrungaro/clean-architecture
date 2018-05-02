<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum\Fixtures;

use Damianopetrungaro\CleanArchitecture\Common\Enum\ReflectionEnum;

/**
 * @method static FixtureEnum A()
 * @method static FixtureEnum B()
 * @method static FixtureEnum C()
 * @method static FixtureEnum VALUE_NUMB()
 */
final class FixtureEnum extends ReflectionEnum
{
    const A = 'VALUE_A';
    const B = 'VALUE_B';
    const C = 'VALUE_C';
    const VALUE_NUMB = 12;

    public function equals($enum): bool
    {
        // TODO: Implement equals() method.
    }
}

<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Enum\Fixtures;

use Damianopetrungaro\CleanArchitecture\Common\Enum\Enum;

/**
 * @method static MyEnum A()
 * @method static MyEnum B()
 * @method static MyEnum C()
 * @method static MyEnum VALUE_NUMB()
 */
final class MyEnum extends Enum
{
    const A = 'VALUE_A';
    const B = 'VALUE_B';
    const C = 'VALUE_C';
    const VALUE_NUMB = 12;
}

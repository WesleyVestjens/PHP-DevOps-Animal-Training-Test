<?php

declare(strict_types=1);

namespace AppTest\Enum;

enum SomeFirstEnum: string
{
    case FOO = 'foo';
    case BAR = 'bar';
    case BAZ = 'baz';
}

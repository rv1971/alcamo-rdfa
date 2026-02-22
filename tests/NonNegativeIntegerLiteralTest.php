<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;
use PHPUnit\Framework\TestCase;

class NonNegativeIntegerLiteralTest extends TestCase
{
    public function testException(): void
    {
        $this->expectException(OutOfRange::class);

        new NonNegativeIntegerLiteral(-3);
    }
}

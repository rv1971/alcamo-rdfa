<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;
use PHPUnit\Framework\TestCase;

class PositiveGYearLiteralTest extends TestCase
{
    public function testException1(): void
    {
        $this->expectException(OutOfRange::class);

        new PositiveGYearLiteral('-0543');
    }

    public function testException2(): void
    {
        $this->expectException(OutOfRange::class);

        new PositiveGYearLiteral(-2500);
    }
}

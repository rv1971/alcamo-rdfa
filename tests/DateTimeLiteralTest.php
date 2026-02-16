<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class DateTimeLiteralTest extends TestCase
{
    public function testBasics(): void
    {
        $literal = new DateTimeLiteral('2026-02-16T19:56+01:00');

        $this->assertSame(
            '2026',
            $literal->format('Y')
        );
    }
}

<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class DcDateTest extends TestCase
{
    public function testBasics(): void
    {
        $literal = new DcDate('2026-02-16T20:00');

        $this->assertSame(
            '16/02/2026',
            $literal->format('d/m/Y')
        );
    }
}

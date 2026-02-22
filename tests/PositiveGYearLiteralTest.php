<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;
use PHPUnit\Framework\TestCase;

class PositiveGYearLiteralTest extends TestCase
{
    public function testCreateXsdText(): void
    {
        $this->assertSame(
            "<?xml version='1.0'?>"
                . "<schema xmlns='http://www.w3.org/2001/XMLSchema' "
                . "targetNamespace='tag:rv1971@web.de,2021:alcamo:ns:base#'>"
                . "<simpleType name='PositiveGYear' xml:id='PositiveGYear'>"
                . "<restriction base='gYear'><minInclusive value='0'/>"
                . "</restriction></simpleType></schema>",
            PositiveGYearLiteral::createXsdText()
        );
    }

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

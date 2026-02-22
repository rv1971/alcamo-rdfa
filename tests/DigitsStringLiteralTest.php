<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;
use PHPUnit\Framework\TestCase;

class DigitsStringLiteralTest extends TestCase
{
    public function testCreateXsdText(): void
    {
        $this->assertSame(
            "<?xml version='1.0'?>"
                . "<schema xmlns='http://www.w3.org/2001/XMLSchema' "
                . "targetNamespace='tag:rv1971@web.de,2021:alcamo:ns:base#'>"
                . "<simpleType name='DigitsString' xml:id='DigitsString'>"
                . "<restriction base='string'><pattern value='\d*'/>"
                . "</restriction></simpleType></schema>",
            DigitsStringLiteral::createXsdText()
        );
    }

    public function testException1(): void
    {
        $this->expectException(SyntaxError::class);

        $this->expectExceptionMessage('"12345x6789" contains non-digits');

        new DigitsStringLiteral('12345x6789');
    }

    public function testException2(): void
    {
        $this->expectException(SyntaxError::class);

        $this->expectExceptionMessage('"-12" contains non-digits');

        new DigitsStringLiteral(-12);
    }
}

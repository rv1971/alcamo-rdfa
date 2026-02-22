<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;
use PHPUnit\Framework\TestCase;

class FourBitStringLiteralTest extends TestCase
{
    public function testCreateXsdText(): void
    {
        $this->assertSame(
            "<?xml version='1.0'?>"
                . "<schema xmlns='http://www.w3.org/2001/XMLSchema' "
                . "targetNamespace='tag:rv1971@web.de,2021:alcamo:ns:base#'>"
                . "<simpleType name='FourBitString' xml:id='FourBitString'>"
                . "<restriction base='string'><pattern value='[0-?]*'/>"
                . "</restriction></simpleType></schema>",
            FourBitStringLiteral::createXsdText()
        );
    }

    public function testBasics(): void
    {
        $literal = FourBitStringLiteral::newFromHex('123fedcba456');

        $this->assertSame('123?>=<;:456', (string)$literal);

        $this->assertSame('123FEDCBA456', $literal->toHex());
    }

    public function testException(): void
    {
        $this->expectException(SyntaxError::class);

        $this->expectExceptionMessage(
            '"123<@>" contains non-four-bit characters'
        );

        new FourBitStringLiteral('123<@>');
    }
}

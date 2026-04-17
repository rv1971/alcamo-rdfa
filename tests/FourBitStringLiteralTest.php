<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;
use PHPUnit\Framework\TestCase;

class FourBitStringLiteralTest extends TestCase
{
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

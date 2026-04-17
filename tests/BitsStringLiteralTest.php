<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;
use PHPUnit\Framework\TestCase;

class BitsStringLiteralTest extends TestCase
{
    public function testException1(): void
    {
        $this->expectException(SyntaxError::class);

        $this->expectExceptionMessage(
            '"012" contains characters other than 0 and 1'
        );

        new BitsStringLiteral('012');
    }

    public function testException2(): void
    {
        $this->expectException(SyntaxError::class);

        $this->expectExceptionMessage(
            '"-1" contains characters other than 0 and 1'
        );

        new BitsStringLiteral(-1);
    }
}

<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;
use PHPUnit\Framework\TestCase;

class AbstractLiteralTest extends TestCase
{
    /**
     * @dataProvider equalityProvider
     */
    public function testEquality($literal1, $literal2, $expectedResult): void
    {
        $this->assertSame($expectedResult, $literal1->equals($literal2));
        $this->assertSame($expectedResult, $literal2->equals($literal1));
    }

    public function equalityProvider(): array
    {
        $literal1 = new DigitsStringLiteral('111');

        $literal2 = new DigitsStringLiteral('222');
        $literal3 = new FourbitStringLiteral('222');
        $literal4 = new StringLiteral('222');
        $literal5 = new LangStringLiteral('222');
        $literal5a = new LangStringLiteral('222', 'ar');

        $literal6 = new AnyUriLiteral('222');

        $literal7 = new DateLiteral(new \DateTime('2026-02-26T15:24'));
        $literal8 = new DateLiteral(new \DateTime('2026-02-26T15:25'));

        $literal9 = new DateTimeLiteral(new \DateTime('2026-02-26T15:24'));

        $literalA = new GYearLiteral(new \DateTime('2026-02-26Z'));
        $literalB = new GYearLiteral(new \DateTime('2026-02-27Z'));
        $literalC = new GYearLiteral(new \DateTime('2026-02-26+07:00'));
        $literalD = new PositiveGYearLiteral(new \DateTime('2026-12-31Z'));

        $literalE = new DecimalLiteral(23);
        $literalF = new IntegerLiteral(23);
        $literalG = new FloatLiteral(23);
        $literalH = new DoubleLiteral(23);

        return [
            [ $literal1, $literal2, false ],

            [ $literal2, $literal3, true ],
            [ $literal2, $literal4, true ],
            [ $literal2, $literal5, true ],
            [ $literal3, $literal4, true ],
            [ $literal3, $literal5, true ],
            [ $literal3, $literal4, true ],

            [ $literal1, $literal6, false ],
            [ $literal2, $literal6, false ],
            [ $literal3, $literal6, false ],
            [ $literal4, $literal6, false ],
            [ $literal5, $literal6, false ],
            [ $literal5, $literal5a, false ],

            [ $literal7, $literal8, true ],
            [ $literal7, $literal9, false ],

            [ $literalA, $literalB, true ],
            [ $literalA, $literalC, false ],
            [ $literalA, $literalD, true ],

            [ $literalE, $literalF, true ],
            [ $literalE, $literalG, false ],
            [ $literalE, $literalH, false ],
            [ $literalG, $literalH, false ]
        ];
    }
}

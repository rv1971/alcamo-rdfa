<?php

namespace alcamo\rdfa;

use alcamo\binary_data\BinaryString;
use alcamo\time\Duration;
use alcamo\uri\Uri;
use PHPUnit\Framework\TestCase;

class LiteralFactoryTest extends TestCase
{
    public const RDF_NS = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

    public const XSD_NS = 'http://www.w3.org/2001/XMLSchema#';

  /**
   * @dataProvider basicsProvider
   */
    public function testBasics(
        $value,
        $datatypeUri,
        $lang,
        $expectedLiteralType,
        $expectedValue,
        $expectedDatatypeUri,
        $expectedString,
        $expectedDigest
    ): void {
        $literalFactory = new LiteralFactory();

        $literal = $literalFactory->create($value, $datatypeUri, $lang);

        $this->assertSame($expectedLiteralType, get_class($literal));

        $this->assertTrue($literal->equals($literal));

        if (is_object($expectedValue)) {
            $this->assertTrue(
                $literal->equals(new $expectedLiteralType($expectedValue))
            );
        } else {
            $this->assertSame($expectedValue, $literal->getValue());
        }

        $this->assertSame(
            $expectedDatatypeUri,
            (string)$literal->getDatatypeUri()
        );

        $this->assertSame($expectedString, (string)$literal);

        if (isset($datatypeUri)) {
            if (is_object($expectedValue)) {
                $this->assertTrue(
                    (new $expectedLiteralType(
                        $literalFactory->convertValue($value, $datatypeUri)
                    ))
                        ->equals(new $expectedLiteralType($expectedValue))
                );
            } else {
                $this->assertSame(
                    $expectedValue,
                    $literalFactory->convertValue($value, $datatypeUri)
                );
            }
        }

        if ($lang) {
            $this->assertSame($lang, (string)$literal->getLang());
        } else {
            $this->assertNull($literal->getLang());
        }

        if ($expectedLiteralType == BooleanLiteral::class) {
            $this->assertSame((int)$literal->getValue(), $literal->toInt());
        } elseif ($literal instanceof ConvertibleToIntInterface) {
            $this->assertSame((int)(string)$literal, $literal->toInt());
        }
    }

    public function basicsProvider(): array
    {
        $year = (new \DateTime())->format('Y');
        $month = (new \DateTime())->format('m');
        $day = (new \DateTime())->format('d');

        return [
            [
                true,
                null,
                null,
                BooleanLiteral::class,
                true,
                self::XSD_NS . 'boolean',
                'true',
                'true'
            ],
            [
                0,
                self::XSD_NS . 'boolean',
                null,
                BooleanLiteral::class,
                false,
                self::XSD_NS . 'boolean',
                'false',
                'false'
            ],
            [
                1,
                self::XSD_NS . 'boolean',
                null,
                BooleanLiteral::class,
                true,
                self::XSD_NS . 'boolean',
                'true',
                'true'
            ],
            [
                null,
                BooleanLiteral::DATATYPE_URI,
                null,
                BooleanLiteral::class,
                false,
                self::XSD_NS . 'boolean',
                'false',
                'false'
            ],
            [
                new \DateTime('2026-02-03T11:04:42+01:00'),
                null,
                null,
                DateTimeLiteral::class,
                new \DateTime('2026-02-03T11:04:42+01:00'),
                self::XSD_NS . 'dateTime',
                '2026-02-03T11:04:42+01:00',
                '2026-02-03T11:04:42+01:00'
            ],
            [
                '2026-02-04T16:05:12Z',
                self::XSD_NS . 'dateTime',
                null,
                DateTimeLiteral::class,
                new \DateTime('2026-02-04T16:05:12Z'),
                self::XSD_NS . 'dateTime',
                '2026-02-04T16:05:12+00:00',
                '2026-02-04T16:05:12+00:00'
            ],
            [
                '-0063-11-08',
                self::XSD_NS . 'date',
                null,
                DateLiteral::class,
                (new \DateTime())->setDate(-63, 11, 8),
                self::XSD_NS . 'date',
                '-0063-11-08',
                '-0063-11-08'
            ],
            [
                '15:01:02',
                self::XSD_NS . 'time',
                null,
                TimeLiteral::class,
                new \DateTime('15:01:02'),
                self::XSD_NS . 'time',
                '15:01:02',
                '15:01:02'
            ],
            [
                new \DateInterval('P40D'),
                null,
                null,
                DurationLiteral::class,
                new Duration('P40D'),
                self::XSD_NS . 'duration',
                'P40D',
                'P40D'
            ],
            [
                null,
                DurationLiteral::DATATYPE_URI,
                null,
                DurationLiteral::class,
                new Duration('P0Y'),
                self::XSD_NS . 'duration',
                'P',
                'P'
            ],
            [
                'PT42.123S',
                self::XSD_NS . 'duration',
                null,
                DurationLiteral::class,
                new Duration('PT42.123S'),
                self::XSD_NS . 'duration',
                'PT42.123S',
                'PT42.123S'
            ],
            [
                3.14,
                null,
                null,
                FloatLiteral::class,
                3.14,
                self::XSD_NS . 'float',
                '3.14',
                '3.14'
            ],
            [
                '2.73',
                self::XSD_NS . 'double',
                null,
                DoubleLiteral::class,
                2.73,
                self::XSD_NS . 'double',
                '2.73',
                '2.73'
            ],
            [
                null,
                FloatLiteral::DATATYPE_URI,
                null,
                FloatLiteral::class,
                0.0,
                self::XSD_NS . 'float',
                '0',
                '0'
            ],
            [
                17.0,
                DecimalLiteral::DATATYPE_URI,
                null,
                DecimalLiteral::class,
                17,
                self::XSD_NS . 'decimal',
                '17',
                '17'
            ],
            [
                17.3,
                DecimalLiteral::DATATYPE_URI,
                null,
                DecimalLiteral::class,
                17.3,
                self::XSD_NS . 'decimal',
                '17.3',
                '17.3'
            ],
            [
                "18",
                DecimalLiteral::DATATYPE_URI,
                null,
                DecimalLiteral::class,
                18,
                self::XSD_NS . 'decimal',
                '18',
                '18'
            ],
            [
                "18.99",
                DecimalLiteral::DATATYPE_URI,
                null,
                DecimalLiteral::class,
                18.99,
                self::XSD_NS . 'decimal',
                '18.99',
                '18.99'
            ],
            [
                0,
                null,
                null,
                IntegerLiteral::class,
                0,
                self::XSD_NS . 'integer',
                '0',
                '0'
            ],
            [
                null,
                self::XSD_NS . 'short',
                null,
                IntegerLiteral::class,
                0,
                self::XSD_NS . 'short',
                '0',
                '0'
            ],
            [
                8.1,
                self::XSD_NS . 'byte',
                null,
                IntegerLiteral::class,
                8,
                self::XSD_NS . 'byte',
                '8',
                '8'
            ],
            [
                44,
                self::XSD_NS . 'nonNegativeInteger',
                null,
                NonNegativeIntegerLiteral::class,
                44,
                self::XSD_NS . 'nonNegativeInteger',
                '44',
                '44'
            ],
            [
                1913,
                PositiveGYearLiteral::DATATYPE_URI,
                null,
                PositiveGYearLiteral::class,
                new \DateTime('1913-10-11'),
                PositiveGYearLiteral::DATATYPE_URI,
                '1913',
                '1913'
            ],
            [
                313,
                PositiveGYearLiteral::DATATYPE_URI,
                null,
                PositiveGYearLiteral::class,
                new \DateTime('0313-02-13'),
                PositiveGYearLiteral::DATATYPE_URI,
                '0313',
                '0313'
            ],
            [
                '1918+01:00',
                PositiveGYearLiteral::DATATYPE_URI,
                null,
                PositiveGYearLiteral::class,
                new \DateTime('1918-02-24+01:00'),
                PositiveGYearLiteral::DATATYPE_URI,
                '1918',
                '1918'
            ],
            [
                '856',
                PositiveGYearLiteral::DATATYPE_URI,
                null,
                PositiveGYearLiteral::class,
                new \DateTime('0856-02-04'),
                PositiveGYearLiteral::DATATYPE_URI,
                '0856',
                '0856'
            ],
            [
                -753,
                self::XSD_NS . 'gYear',
                null,
                GYearLiteral::class,
                (new \DateTime())->setDate(-753, 1, 1),
                GYearLiteral::DATATYPE_URI,
                '-0753',
                '-0753'
            ],
            [
                '-753Z',
                self::XSD_NS . 'gYear',
                null,
                GYearLiteral::class,
                (new \DateTime())->setDate(-753, 1, 1)
                    ->setTimeZone(new \DateTimeZone('+0000')),
                GYearLiteral::DATATYPE_URI,
                '-0753',
                '-0753'
            ],
            [
                '-753-0200',
                self::XSD_NS . 'gYear',
                null,
                GYearLiteral::class,
                (new \DateTime())->setDate(-753, 1, 1)
                    ->setTimeZone(new \DateTimeZone('-0200')),
                GYearLiteral::DATATYPE_URI,
                '-0753',
                '-0753'
            ],
            [
                "Don't panic",
                self::RDF_NS . 'langString',
                null,
                LangStringLiteral::class,
                "Don't panic",
                self::RDF_NS . 'langString',
                "Don't panic",
                "\"Don't panic\""
            ],
            [
                Lang::newFromPrimary('is'),
                null,
                null,
                LanguageLiteral::class,
                Lang::newFromPrimary('is'),
                self::XSD_NS . 'language',
                'is',
                'is'
            ],
            [
                'et-EE',
                self::XSD_NS . 'language',
                null,
                LanguageLiteral::class,
                Lang::newFromPrimaryAndRegion('et', 'EE'),
                self::XSD_NS . 'language',
                'et-EE',
                'et-EE'
            ],
            [
                'Foo',
                null,
                null,
                StringLiteral::class,
                'Foo',
                self::XSD_NS . 'string',
                'Foo',
                'Foo'
            ],
            [
                'bar',
                'http://schema.example.org#Bar',
                null,
                StringLiteral::class,
                'bar',
                'http://schema.example.org#Bar',
                'bar',
                'bar'
            ],
            [
                'foo:bar',
                self::XSD_NS . 'NOTATION',
                null,
                NotationLiteral::class,
                'foo:bar',
                self::XSD_NS . 'NOTATION',
                'foo:bar',
                'foo:bar'
            ],
            [
                'baz',
                self::XSD_NS . 'QName',
                null,
                QNameLiteral::class,
                'baz',
                self::XSD_NS . 'QName',
                'baz',
                'baz'
            ],
            [
                '00123456789123456789',
                DigitsStringLiteral::DATATYPE_URI,
                null,
                DigitsStringLiteral::class,
                '00123456789123456789',
                DigitsStringLiteral::DATATYPE_URI,
                '00123456789123456789',
                '00123456789123456789'
            ],
            [
                ';7123456=2602>4711?',
                FourBitStringLiteral::DATATYPE_URI,
                null,
                FourBitStringLiteral::class,
                ';7123456=2602>4711?',
                FourBitStringLiteral::DATATYPE_URI,
                ';7123456=2602>4711?',
                ';7123456=2602>4711?'
            ],
            [
                'Foo',
                null,
                'pt-BR',
                LangStringLiteral::class,
                'Foo',
                self::RDF_NS . 'langString',
                'Foo',
                '"Foo"@pt-BR'
            ],
            [
                'bar',
                'http://schema.example.org#Bar',
                'uk-CA',
                LangStringLiteral::class,
                'bar',
                'http://schema.example.org#Bar',
                'bar',
                '"bar"@uk-CA'
            ],
            [
                new LangStringLiteral("FOO-BAR", 'jp'),
                self::XSD_NS . 'string',
                null,
                StringLiteral::class,
                "FOO-BAR",
                self::XSD_NS . 'string',
                "FOO-BAR",
                "FOO-BAR"
            ],
            [
                null,
                'http://schema.example.org#Bar',
                'la-VA',
                LangStringLiteral::class,
                '',
                'http://schema.example.org#Bar',
                '',
                '""@la-VA'
            ],
            [
                '1971',
                self::XSD_NS . 'gYear',
                null,
                GYearLiteral::class,
                new \DateTime('1971'),
                self::XSD_NS . 'gYear',
                '1971',
                '1971'
            ],
            [
                (new \DateTime())->setDate(-7, $month, $day),
                self::XSD_NS . 'gYear',
                null,
                GYearLiteral::class,
                (new \DateTime())->setDate(-7, $month, $day),
                self::XSD_NS . 'gYear',
                '-0007',
                '-0007'
            ],
            [
                '1975-12',
                self::XSD_NS . 'gYearMonth',
                null,
                GYearMonthLiteral::class,
                new \DateTime('1975-12'),
                self::XSD_NS . 'gYearMonth',
                '1975-12',
                '1975-12'
            ],
            [
                7,
                self::XSD_NS . 'gMonth',
                null,
                GMonthLiteral::class,
                new \DateTime("$year-07-$day"),
                self::XSD_NS . 'gMonth',
                '07',
                '07'
            ],
            [
                '12-8',
                self::XSD_NS . 'gMonthDay',
                null,
                GMonthDayLiteral::class,
                new \DateTime("$year-12-08"),
                self::XSD_NS . 'gMonthDay',
                '12-08',
                '12-08'
            ],
            [
                17,
                self::XSD_NS . 'gDay',
                null,
                GDayLiteral::class,
                new \DateTime("$year-$month-17"),
                self::XSD_NS . 'gDay',
                '17',
                '17'
            ],
            [
                'ab12CD',
                self::XSD_NS . 'hexBinary',
                null,
                HexBinaryLiteral::class,
                BinaryString::newFromHex('ab12cd'),
                self::XSD_NS . 'hexBinary',
                'AB12CD',
                'AB12CD'
            ],
            [
                'EjRWerw=',
                self::XSD_NS . 'base64Binary',
                null,
                Base64BinaryLiteral::class,
                BinaryString::newFromHex('1234567abc'),
                self::XSD_NS . 'base64Binary',
                'EjRWerw=',
                'EjRWerw='
            ],
            [
                'http://www.example.edu',
                self::XSD_NS . 'anyURI',
                null,
                AnyUriLiteral::class,
                new Uri('http://www.example.edu'),
                self::XSD_NS . 'anyURI',
                'http://www.example.edu',
                'http://www.example.edu'
            ]
        ];
    }

    public function testLangStringLiteral(): void
    {
        $literal = new LangStringLiteral('Sælar', 'is');

        $this->assertEquals(Lang::newFromPrimary('is'), $literal->getLang());
    }
}

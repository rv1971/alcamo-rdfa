<?php

namespace alcamo\rdfa;

use alcamo\time\Duration;
use PHPUnit\Framework\TestCase;

class LiteralFactoryTest extends TestCase
{
    public const RDF_NS_URI = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

    public const XSD_NS_URI = 'http://www.w3.org/2001/XMLSchema#';

  /**
   * @dataProvider basicsProvider
   */
    public function testBasics(
        $value,
        $datatypeUri,
        $expectedLiteralType,
        $expectedValue,
        $expectedDatatypeUri,
        $expectedString
    ): void {
        $literalFactory = new LiteralFactory();

        $literal = $literalFactory->create($value, $datatypeUri);

        $this->assertSame($expectedLiteralType, get_class($literal));

        if (is_object($expectedValue)) {
            $this->assertEquals($expectedValue, $literal->getValue());
        } else {
            $this->assertSame($expectedValue, $literal->getValue());
        }

        $this->assertSame($expectedDatatypeUri, $literal->getDatatypeUri());

        $this->assertSame($expectedString, (string)$literal);

        $this->assertNull($literal->getLang());

        if (isset($datatypeUri)) {
            if (is_object($expectedValue)) {
                $this->assertEquals(
                    $expectedValue,
                    $literalFactory->convertValue($value, $datatypeUri)
                );
            } else {
                $this->assertSame(
                    $expectedValue,
                    $literalFactory->convertValue($value, $datatypeUri)
                );
            }
        }
    }

    public function basicsProvider(): array
    {
        return [
            [
                true,
                null,
                BooleanLiteral::class,
                true,
                self::XSD_NS_URI . 'boolean',
                'true'
            ],
            [
                0,
                self::XSD_NS_URI . 'boolean',
                BooleanLiteral::class,
                false,
                self::XSD_NS_URI . 'boolean',
                'false'
            ],
            [
                1,
                self::XSD_NS_URI . 'boolean',
                BooleanLiteral::class,
                true,
                self::XSD_NS_URI . 'boolean',
                'true'
            ],
            [
                new \DateTime('2026-02-03T11:04:42+01:00'),
                null,
                DateTimeLiteral::class,
                new \DateTime('2026-02-03T11:04:42+01:00'),
                self::XSD_NS_URI . 'dateTime',
                '2026-02-03T11:04:42+01:00'
            ],
            [
                '2026-02-04T16:05:12Z',
                self::XSD_NS_URI . 'dateTime',
                DateTimeLiteral::class,
                new \DateTime('2026-02-04T16:05:12Z'),
                self::XSD_NS_URI . 'dateTime',
                '2026-02-04T16:05:12+00:00'
            ],
            [
                '2026-02-05',
                self::XSD_NS_URI . 'date',
                DateLiteral::class,
                new \DateTime('2026-02-05'),
                self::XSD_NS_URI . 'date',
                '2026-02-05'
            ],
            [
                '15:01:02',
                self::XSD_NS_URI . 'time',
                TimeLiteral::class,
                new \DateTime('15:01:02'),
                self::XSD_NS_URI . 'time',
                '15:01:02'
            ],
            [
                new \DateInterval('P40D'),
                null,
                DurationLiteral::class,
                new Duration('P40D'),
                self::XSD_NS_URI . 'duration',
                'P40D'
            ],
            [
                'PT42.123S',
                self::XSD_NS_URI . 'duration',
                DurationLiteral::class,
                new Duration('PT42.123S'),
                self::XSD_NS_URI . 'duration',
                'PT42.123S'
            ],
            [
                3.14,
                null,
                FloatLiteral::class,
                3.14,
                self::XSD_NS_URI . 'double',
                '3.14'
            ],
            [
                '2.73',
                self::XSD_NS_URI . 'float',
                FloatLiteral::class,
                2.73,
                self::XSD_NS_URI . 'float',
                '2.73'
            ],
            [
                0,
                null,
                IntegerLiteral::class,
                0,
                self::XSD_NS_URI . 'integer',
                '0'
            ],
            [
                8.1,
                self::XSD_NS_URI . 'byte',
                IntegerLiteral::class,
                8,
                self::XSD_NS_URI . 'byte',
                '8'
            ],
            [
                "Don't panic",
                self::RDF_NS_URI . 'langString',
                LangStringLiteral::class,
                "Don't panic",
                self::RDF_NS_URI . 'langString',
                "Don't panic"
            ],
            [
                Lang::newFromPrimary('is'),
                null,
                LanguageLiteral::class,
                Lang::newFromPrimary('is'),
                self::XSD_NS_URI . 'language',
                'is'
            ],
            [
                'et-EE',
                self::XSD_NS_URI . 'language',
                LanguageLiteral::class,
                Lang::newFromPrimaryAndRegion('et', 'EE'),
                self::XSD_NS_URI . 'language',
                'et-EE'
            ],
            [
                'Foo',
                null,
                Literal::class,
                'Foo',
                self::XSD_NS_URI . 'string',
                'Foo'
            ],
            [
                'bar',
                'http://schema.example.org#Bar',
                Literal::class,
                'bar',
                'http://schema.example.org#Bar',
                'bar'
            ]
        ];
    }

    public function testLangStringLiteral(): void
    {
        $literal = new LangStringLiteral('Sælar', 'is');

        $this->assertEquals(Lang::newFromPrimary('is'), $literal->getLang());
    }
}

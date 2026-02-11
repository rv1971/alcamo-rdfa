<?php

namespace alcamo\rdfa;

use alcamo\time\Duration;
use PHPUnit\Framework\TestCase;

class LiteralFactoryTest extends TestCase
{
    public const RDF_NS_NAME = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

    public const XSD_NS_NAME = 'http://www.w3.org/2001/XMLSchema#';

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

        if (is_object($expectedValue)) {
            $this->assertEquals($expectedValue, $literal->getValue());
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

        if ($lang) {
            $this->assertSame($lang, (string)$literal->getLang());
        } else {
            $this->assertNull($literal->getLang());
        }
    }

    public function basicsProvider(): array
    {
        return [
            [
                true,
                null,
                null,
                BooleanLiteral::class,
                true,
                self::XSD_NS_NAME . 'boolean',
                'true',
                'true'
            ],
            [
                0,
                self::XSD_NS_NAME . 'boolean',
                null,
                BooleanLiteral::class,
                false,
                self::XSD_NS_NAME . 'boolean',
                'false',
                'false'
            ],
            [
                1,
                self::XSD_NS_NAME . 'boolean',
                null,
                BooleanLiteral::class,
                true,
                self::XSD_NS_NAME . 'boolean',
                'true',
                'true'
            ],
            [
                new \DateTime('2026-02-03T11:04:42+01:00'),
                null,
                null,
                DateTimeLiteral::class,
                new \DateTime('2026-02-03T11:04:42+01:00'),
                self::XSD_NS_NAME . 'dateTime',
                '2026-02-03T11:04:42+01:00',
                '2026-02-03T11:04:42+01:00'
            ],
            [
                '2026-02-04T16:05:12Z',
                self::XSD_NS_NAME . 'dateTime',
                null,
                DateTimeLiteral::class,
                new \DateTime('2026-02-04T16:05:12Z'),
                self::XSD_NS_NAME . 'dateTime',
                '2026-02-04T16:05:12+00:00',
                '2026-02-04T16:05:12+00:00'
            ],
            [
                '2026-02-05',
                self::XSD_NS_NAME . 'date',
                null,
                DateLiteral::class,
                new \DateTime('2026-02-05'),
                self::XSD_NS_NAME . 'date',
                '2026-02-05',
                '2026-02-05'
            ],
            [
                '15:01:02',
                self::XSD_NS_NAME . 'time',
                null,
                TimeLiteral::class,
                new \DateTime('15:01:02'),
                self::XSD_NS_NAME . 'time',
                '15:01:02',
                '15:01:02'
            ],
            [
                new \DateInterval('P40D'),
                null,
                null,
                DurationLiteral::class,
                new Duration('P40D'),
                self::XSD_NS_NAME . 'duration',
                'P40D',
                'P40D'
            ],
            [
                'PT42.123S',
                self::XSD_NS_NAME . 'duration',
                null,
                DurationLiteral::class,
                new Duration('PT42.123S'),
                self::XSD_NS_NAME . 'duration',
                'PT42.123S',
                'PT42.123S'
            ],
            [
                3.14,
                null,
                null,
                FloatLiteral::class,
                3.14,
                self::XSD_NS_NAME . 'double',
                '3.14',
                '3.14'
            ],
            [
                '2.73',
                self::XSD_NS_NAME . 'float',
                null,
                FloatLiteral::class,
                2.73,
                self::XSD_NS_NAME . 'float',
                '2.73',
                '2.73'
            ],
            [
                0,
                null,
                null,
                IntegerLiteral::class,
                0,
                self::XSD_NS_NAME . 'integer',
                '0',
                '0'
            ],
            [
                8.1,
                self::XSD_NS_NAME . 'byte',
                null,
                IntegerLiteral::class,
                8,
                self::XSD_NS_NAME . 'byte',
                '8',
                '8'
            ],
            [
                "Don't panic",
                self::RDF_NS_NAME . 'langString',
                null,
                LangStringLiteral::class,
                "Don't panic",
                self::RDF_NS_NAME . 'langString',
                "Don't panic",
                "\"Don't panic\""
            ],
            [
                Lang::newFromPrimary('is'),
                null,
                null,
                LanguageLiteral::class,
                Lang::newFromPrimary('is'),
                self::XSD_NS_NAME . 'language',
                'is',
                'is'
            ],
            [
                'et-EE',
                self::XSD_NS_NAME . 'language',
                null,
                LanguageLiteral::class,
                Lang::newFromPrimaryAndRegion('et', 'EE'),
                self::XSD_NS_NAME . 'language',
                'et-EE',
                'et-EE'
            ],
            [
                'Foo',
                null,
                null,
                StringLiteral::class,
                'Foo',
                self::XSD_NS_NAME . 'string',
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
                'Foo',
                null,
                'pt-BR',
                LangStringLiteral::class,
                'Foo',
                self::RDF_NS_NAME . 'langString',
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
                self::XSD_NS_NAME . 'string',
                null,
                StringLiteral::class,
                "FOO-BAR",
                self::XSD_NS_NAME . 'string',
                "FOO-BAR",
                "FOO-BAR"
            ],

        ];
    }

    public function testLangStringLiteral(): void
    {
        $literal = new LangStringLiteral('Sælar', 'is');

        $this->assertEquals(Lang::newFromPrimary('is'), $literal->getLang());
    }
}

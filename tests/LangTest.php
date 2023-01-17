<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class LangTest extends TestCase
{
    /**
     * @dataProvider newFromPrimaryProvider
     */
    public function testNewFromPrimary($primary): void
    {
        $lang = Lang::newFromPrimary($primary);

        $this->assertSame($primary, (string)$lang);

        $this->assertSame([ 'language' => $primary ], $lang->getSubtags());

        $this->assertSame($primary, $lang->getPrimary());

        $this->assertNull($lang->getRegion());
    }

    public function newFromPrimaryProvider(): array
    {
        return [
            [ 'ga' ],
            [ 'ie' ]
        ];
    }

    /**
     * @dataProvider newFromPrimaryAndRegionProvider
     */
    public function testNewFromPrimaryAndRegion($primary, $region): void
    {
        $lang = Lang::newFromPrimaryAndRegion($primary, $region);

        $this->assertSame("$primary-$region", (string)$lang);

        $this->assertSame(
            [ 'language' => $primary, 'region' => $region ],
            $lang->getSubtags()
        );

        $this->assertSame($primary, $lang->getPrimary());

        $this->assertSame($region, $lang->getRegion());
    }

    public function newFromPrimaryAndRegionProvider(): array
    {
        return [
            [ 'ga', 'IE' ],
            [ 'ie', 'KZ' ],
            [ 'it', 'US' ]
        ];
    }

    /**
     * @dataProvider newFromStringProvider
     */
    public function testNewFromString(
        $string,
        $expectedString,
        $expectedSubtags,
        $expectedPrimary,
        $expectedRegion
    ): void {
        $lang = Lang::newFromString($string);

        $this->assertSame($expectedString, (string)$lang);

        $this->assertSame($expectedSubtags, $lang->getSubtags());

        $this->assertSame($expectedPrimary, $lang->getPrimary());

        $this->assertSame($expectedRegion, $lang->getRegion());
    }

    public function newFromStringProvider(): array
    {
        return [
            [ 'cs', 'cs', [ 'language' => 'cs' ], 'cs', null ],
            [
                'it-AR',
                'it-AR',
                [ 'language' => 'it', 'region' => 'AR' ],
                'it',
                'AR'
            ],
            [
                'kz_Cyrl_KZ',
                'kz-Cyrl-KZ',
                [ 'language' => 'kz', 'script' => 'Cyrl', 'region' => 'KZ' ],
                'kz',
                'KZ'
            ],
            [
                'yo-x-foo',
                'yo-x-foo',
                [ 'language' => 'yo', 'private0' => 'foo' ],
                'yo',
                null
            ]
        ];
    }

    /**
     * @dataProvider newFromCurrentLocaleProvider
     */
    public function testNewFromCurrentLocale(string $locale): void
    {
        setlocale(LC_ALL, $locale);

        $lang = Lang::newFromCurrentLocale();

        $this->assertSame(
            \Locale::parseLocale($locale),
            $lang->getSubtags()
        );
    }

    public function newFromCurrentLocaleProvider(): array
    {
        return [
            [ 'en_US' ],
            [ 'es_ES' ],
            [ 'fr_CA' ],
            [ 'pt_BR' ]
        ];
    }
}

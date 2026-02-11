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

    public function testNewFromEmptyString(): void
    {
        $this->assertNull(Lang::newFromString(''));
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
            [ 'es_ES' ],
            [ 'fr_CA' ],
            [ 'pt_BR' ],
            [ 'en_US' ]
        ];
    }

    /**
     * @dataProvider countCommonSubtagsProvider
     */
    public function testCountCommonSubtags($lang1, $lang2, $expectedCount): void
    {
        $this->assertSame(
            $expectedCount,
            Lang::newFromString($lang1)->countCommonSubtags($lang2)
        );
    }

    public function countCommonSubtagsProvider(): array
    {
        return [
            [ 'en', 'fr', -1 ],
            [ 'en-US', null, 0 ],
            [ 'en-CA', '', 0 ],
            [ 'en-IE', 'en', 1 ],
            [ 'en-IE', 'en-CA', 1 ],
            [ 'en-IE', 'en-Latn', 1 ],
            [ 'en-IE', 'en-IE', 2 ],
            [ 'en-IE', 'en-ie', 2 ],
            [ 'en-IE', 'en-Latn-IE', 2 ],
            [ 'en-Latn-IE', 'en-Latn-IE', 3 ],
            [ 'kk-Cyrl', 'KK', 1 ],
            [ 'kk-Cyrl', 'kk-Arab', 1 ],
            [ 'kk-Cyrl-CN', 'kk-Arab-CN', 1 ],
            [ 'kk-Cyrl-CN-x-foo', 'kk-KZ-x-foo', 1 ],
            [ 'kk-Cyrl', 'kk-Cyrl', 2 ],
            [ 'kk-Cyrl-CN', 'kk-CN', 2 ],
            [ 'kk-Cyrl-CN-x-foo', 'kk-x-foo', 2 ],
            [ 'kk-Cyrl-CN-x-foo', 'kk-CN-x-foo', 3 ]
        ];
    }
}

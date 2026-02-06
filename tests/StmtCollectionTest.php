<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class StmtCollectionTest extends TestCase
{
    /**
     * @dataProvider findLangProvider
     */
    public function testFindLang($lang, $expectedValue): void
    {
        $collection = new StmtCollection(
            [
                new DcAbstract('no-LangStringLiteral'),
                new DcAbstract(new LangStringLiteral('no-lang')),
                new DcAbstract(new LangStringLiteral('en', 'en')),
                new DcConformsTo(
                    'http://www.example.org/en-IE',
                    [ [ 'dc:language', 'en-IE' ] ]
                ),
                new DcAbstract(new LangStringLiteral('kk-Cyrl', 'kk-Cyrl')),
                new DcConformsTo('http://www.example.org/other'),
                new DcAbstract(new LangStringLiteral('kk-Latn-cn', 'kk-Latn-cn'))
            ]
        );

        $this->assertSame($expectedValue, (string)$collection->findLang($lang));
    }

    public function findLangProvider(): array
    {
        return [
            [ 'fr', 'no-LangStringLiteral' ],
            [ 'en-US', 'en' ],
            [ 'en-IE', 'http://www.example.org/en-IE' ],
            [ 'kk', 'kk-Cyrl' ],
            [ 'kk-Arab', 'kk-Cyrl' ],
            [ 'kk-Curl-ru', 'kk-Cyrl' ],
            [ 'kk-Latn', 'kk-Latn-cn' ],
            [ 'kk-Latn-kz', 'kk-Latn-cn' ]
        ];
    }
}

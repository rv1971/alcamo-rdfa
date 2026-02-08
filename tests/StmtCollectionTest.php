<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;
use PHPUnit\Framework\TestCase;

class StmtCollectionTest extends TestCase
{
    public function testAddExcpetion(): void
    {
        $collection = new StmtCollection([ new DcTitle('Hello') ]);

        $this->expectException(DataValidationFailed::class);

        $this->expectExceptionMessage(
            'Validation failed; attempt to insert a '
                . 'http://purl.org/dc/terms/abstract statement into a '
                . 'collection of http://purl.org/dc/terms/title statements'
        );

        $collection->addStmt(new DcAbstract('Lorem ipsum'));
    }

    /**
     * @dataProvider findLangProvider
     */
    public function testFindLang($lang, $expectedValue): void
    {
        $collection = new StmtCollection(
            [
                new DcCreator('no-LangStringLiteral'),
                new DcCreator(new LangStringLiteral('no-lang')),
                new DcCreator(new LangStringLiteral('en', 'en')),
                new DcCreator(
                    new Node(
                        'http://www.example.org/en-IE',
                        [ [ 'dc:language', 'en-IE' ] ]
                    )
                ),
                new DcCreator(new LangStringLiteral('kk-Cyrl', 'kk-Cyrl')),
                new DcCreator(new Node('http://www.example.org/other')),
                new DcCreator(new LangStringLiteral('kk-Latn-cn', 'kk-Latn-cn'))
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

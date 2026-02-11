<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;
use PHPUnit\Framework\TestCase;

class StmtCollectionTest extends TestCase
{
    public function testAddException(): void
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
    public function testFindLang(
        $collection,
        $lang,
        $disableFallback,
        $expectedValue
    ): void {
        if (isset($expectedValue)) {
            $this->assertSame(
                $expectedValue,
                (string)$collection->findLang($lang, $disableFallback)
            );
        } else {
            $this->assertNull($collection->findLang($lang, $disableFallback));
        }
    }

    public function findLangProvider(): array
    {
        $collection0 = new StmtCollection();

        $collection1 = new StmtCollection(
            [
                new DcCreator(new LangStringLiteral('en', 'en')),
                new DcCreator(
                    new Node(
                        'http://www.example.org/en-IE',
                        [ [ 'dc:language', 'en-IE' ] ]
                    )
                ),
                new DcCreator(new LangStringLiteral('kk-Cyrl', 'kk-Cyrl')),
                new DcCreator(new LangStringLiteral('kk-Latn-CN', 'kk-Latn-CN'))
            ]
        );

        $collection2 = (clone $collection1)
            ->addStmt(new DcCreator('no-LangStringLiteral'))
            ->addStmt(new DcCreator(new Node('http://www.example.org/other')))
            ->addStmt(new DcCreator(new LangStringLiteral('no-lang')));

        return [
            [ $collection0, 'la', null, null ],
            [ $collection1, null, null, 'en' ],
            [ $collection1, '', null, 'en' ],
            [ $collection1, 'fr', null, 'en' ],
            [ $collection1, 'fr', true, null ],
            [ $collection1, 'en-US', false, 'en' ],
            [ $collection1, 'en-US', true, 'en' ],
            [ $collection1, 'en-IE', null, 'http://www.example.org/en-IE' ],
            [ $collection1, 'et', null, 'en' ],
            [ $collection1, 'et', true, null ],
            [ $collection1, 'kk', null, 'kk-Cyrl' ],
            [ $collection1, 'kk', true, 'kk-Cyrl' ],
            [ $collection1, 'kk-Arab', null, 'kk-Cyrl' ],
            [ $collection1, 'kk-Arab', true, 'kk-Cyrl' ],
            [ $collection1, 'kk-Curl-ru', null, 'kk-Cyrl' ],
            [ $collection1, 'kk-Latn', true, 'kk-Latn-CN' ],
            [ $collection1, 'kk-Latn-KZ', true, 'kk-Latn-CN' ],
            [ $collection1, 'fr', null, 'en' ],
            [ $collection2, 'fr', true, 'no-LangStringLiteral' ],
            [ $collection2, 'et', true, 'no-LangStringLiteral' ]
        ];
    }
}

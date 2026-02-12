<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;
use alcamo\xml\NamespaceConstantsInterface;
use Ds\Set;
use PHPUnit\Framework\TestCase;

class RdfaDataTest extends TestCase implements NamespaceConstantsInterface
{
    public function newEmpty(): void
    {
        $rdfaData = RdfaData::newEmpty();

        $this->assertSame(0, count($rdfaData));
        $this->assertSame([], $rdfaData->getCurieToUri());
    }

    /**
     * @dataProvider newFromIterableProvider
     */
    public function testNewFromIterable(
        $inputData,
        $flags,
        $expectedData,
        $expecetedCurieToUri
    ): void {
        $rdfaFactory = new RdfaFactory();

        $rdfaData = RdfaData::newFromIterable($inputData, null, $flags);

        $this->assertSame(count($expectedData), count($rdfaData));

        foreach ($expectedData as $prop => $expectedStmts) {
            $this->assertSame(count($expectedStmts), count($rdfaData[$prop]));

            foreach ($expectedStmts as $key => $stmt) {
                $this->assertSame((string)$stmt, (string)$rdfaData[$prop][$key]);

                $this->assertEquals(
                    $stmt,
                    $rdfaFactory->createStmtFromUriAndData(
                        $rdfaData[$prop][$key]->getPropUri(),
                        $rdfaData[$prop][$key]->getObject()
                    )
                );
            }
        }
    }

    public function newFromIterableProvider(): array
    {
        return [
            [
                [
                    [ 'dc:title', new DcTitle('Lorem ipsum dolor sit amet') ],
                    [
                        'dc:conformsTo',
                        [
                            'https://semver.org/spec/v2.0.0.html',
                            [ [ 'dc:title', 'Semantic Versioning' ] ]
                        ]
                    ],
                    [ 'dc:publisher', null ],
                    [ 'dc:conformsTo', 'https://example.org/strict' ],
                    [ 'dc:created', '2025-10-21T17:17+02:00' ],
                    [ 'dc:foo', 'bar' ]
                ],
                null,
                [
                    self::DC_NS . 'title' => [
                        '"Lorem ipsum dolor sit amet"'
                            => new DcTitle('Lorem ipsum dolor sit amet')
                    ],
                    self::DC_NS . 'conformsTo' => [
                        'https://semver.org/spec/v2.0.0.html'
                            => new DcConformsTo(
                                'https://semver.org/spec/v2.0.0.html',
                                RdfaData::newFromIterable(
                                    [ [ 'dc:title', 'Semantic Versioning' ] ]
                                )
                            ),
                        'https://example.org/strict'
                        => new DcConformsTo('https://example.org/strict')
                    ],
                    self::DC_NS . 'created' => [
                        '2025-10-21T17:17:00+02:00'
                            => new DcCreated('2025-10-21T17:17+02:00')
                    ],
                    self::DC_NS . 'foo' => [
                        'bar' => new SimpleStmt(self::DC_NS, 'dc', 'foo', 'bar')
                    ]
                ],
                [
                    'dc:title' => self::DC_NS . 'title',
                    'dc:conformsTo' => self::DC_NS . 'conformsTo',
                    'dc:created' => self::DC_NS . 'created',
                    'dc:foo' => self::DC_NS . 'foo'
                ]
            ],
            [
                [
                    [ 'http:content-length', 4711 ]
                ],
                null,
                [
                    self::HTTP_NS . 'content-length' => [
                        '4711' => new HttpContentLength(4711)
                    ]
                ],
                [
                    'http:content-length' => self::HTTP_NS . 'content-length'
                ]
            ],
            [
                [
                    [ 'dc:format', 'application/xml' ],
                    [ 'dc:creator', null ]
                ],
                null,
                [
                    self::DC_NS . 'format'
                        => [ 'application/xml' => 'application/xml' ]
                ],
                [
                    'dc:format' => self::DC_NS . 'format'
                ]
            ],
            [
                [
                    [ self::DC_NS . 'coverage', 2026 ],
                    [ 'http://www.example.com/foo', 'bar' ]
                ],
                RdfaData::URI_AS_KEY,
                [
                    self::DC_NS . 'coverage' => [
                        '2026' => new DcCoverage(2026)
                    ],
                    'http://www.example.com/foo' => [ 'bar' => 'bar' ]
                ],
                [
                    'dc:coverage' => self::DC_NS . 'coverage'
                ]
            ],
            [
                [
                    [
                        'dc:title',
                        new DcTitle(new LangStringLiteral('Traces', 'en'))
                    ],
                    [
                        'dc:title',
                        new DcTitle(new LangStringLiteral('Traces', 'fr'))
                    ]
                ],
                null,
                [
                    self::DC_NS . 'title' => [
                        '"Traces"@en'
                            => new DcTitle(
                                new LangStringLiteral('Traces', 'en')
                            ),
                        '"Traces"@fr'
                            => new DcTitle(
                                new LangStringLiteral('Traces', 'fr')
                            )
                    ]
                ],
                [
                    'dc:title' => self::DC_NS . 'title'
                ]
            ]
        ];
    }

    public function testNewFromIterableException1(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'object property CURIE "dc:title" does not match key "dc:tittle"'
        );

        RdfaData::newFromIterable(
            [ [ 'dc:tittle', new DcTitle('Lorem') ] ]
        );
    }

    public function testNewFromIterableException2(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'object property CURIE "dc:title" does not match key "dc:alternative"'
        );

        RdfaData::newFromIterable(
            [ [ 'dc:alternative', new DcTitle('Ipsum') ] ]
        );
    }

    public function testNewFromIterableException3(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'object property URI "' . self::DC_NS . 'title" '
                . 'does not match key "' . self::DC_NS . 'tittle"'
        );

        RdfaData::newFromIterable(
            [ [ self::DC_NS . 'tittle', new DcTitle('Lorem') ] ],
            null,
            RdfaData::URI_AS_KEY
        );
    }

    /**
     * @dataProvider findStmtWithLangProvider
     */
    public function testFindStmtWithLang(
        $prop,
        $lang,
        $disableFallback,
        $expectedData
    ): void {
        $rdfaData = RdfaData::newFromIterable(
            [
                [ 'dc:title', new LangStringLiteral('Titolo', 'it') ],
                [ 'dc:title', new LangStringLiteral('Titre', 'fr') ]
            ]
        );

        $this->assertSame(
            $expectedData,
            (string)$rdfaData->findStmtWithLang($prop, $lang, $disableFallback)
        );
    }

    public function findStmtWithLangProvider(): array
    {
        return [
            [ 'dc:title', null, null, 'Titolo' ],
            [ 'dc:title', 'en', null, 'Titolo' ],
            [ 'dc:title', 'en', true, '' ],
            [ 'dc:title', 'it', null, 'Titolo' ],
            [ 'dc:title', 'fr', null, 'Titre' ],
            [ 'dc:creator', null, null, '' ]
        ];
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($inputData1, $inputData2, $expectedData): void
    {
        $rdfaData = RdfaData::newFromIterable($inputData1)
            ->add(RdfaData::newFromIterable($inputData2));

        $expectedArray = RdfaData::newFromIterable($expectedData);

        $this->assertSame(count($expectedArray), count($rdfaData));

        foreach ($expectedArray as $key => $value) {
            $this->assertEquals($expectedArray[$key], $rdfaData[$key]);
        }
    }

    public function addProvider(): array
    {
        return [
            [
                [
                    [ 'dc:title', 'Lorem ipsum' ],
                    [ 'dc:alternative', 'Dolor sit amet' ],
                    [ 'dc:conformsTo', 'Rulebook 1' ],
                    [ 'dc:creator', 'Alice' ],
                    [ 'dc:accessRights', 'read' ],
                    [ 'dc:accessRights', 'modify' ],
                    [ 'dc:creator', 'Bob' ]
                ],
                [
                    [ 'dc:type', 'Software' ],
                    [ 'dc:creator', 'Charles' ],
                    [ 'dc:accessRights', 'publish' ],
                    [ 'dc:conformsTo', 'Rulebook 2' ],
                    [ 'dc:accessRights', 'delete' ],
                    [ 'dc:alternative', 'Consetetur sadipscing elitr' ],
                    [ 'dc:conformsTo', 'Rulebook 3' ],
                    [ 'dc:title', 'Lorem ipsum again' ]
                ],
                [
                    [ 'dc:title', 'Lorem ipsum' ],
                    [ 'dc:title', 'Lorem ipsum again' ],
                    [ 'dc:alternative', 'Dolor sit amet' ],
                    [ 'dc:alternative', 'Consetetur sadipscing elitr' ],
                    [ 'dc:conformsTo', 'Rulebook 1' ],
                    [ 'dc:conformsTo', 'Rulebook 2' ],
                    [ 'dc:conformsTo', 'Rulebook 3' ],
                    [ 'dc:creator', 'Alice' ],
                    [ 'dc:creator', 'Bob' ],
                    [ 'dc:creator', 'Charles' ],
                    [ 'dc:accessRights', 'read' ],
                    [ 'dc:accessRights', 'modify' ],
                    [ 'dc:accessRights', 'publish' ],
                    [ 'dc:accessRights', 'delete' ],
                    [ 'dc:type', 'Software' ]
                ],

            ]
        ];
    }

    /**
     * @dataProvider replaceProvider
     */
    public function testReplace($inputData1, $inputData2, $expectedData): void
    {
        $rdfaData = RdfaData::newFromIterable($inputData1)
            ->replace(RdfaData::newFromIterable($inputData2));

        $expectedArray = RdfaData::newFromIterable($expectedData);

        $this->assertSame(count($expectedArray), count($rdfaData));

        foreach ($expectedArray as $key => $value) {
            $this->assertEquals($expectedArray[$key], $rdfaData[$key]);
        }
    }

    public function replaceProvider(): array
    {
        return [
            [
                [
                    [ 'dc:title', 'Lorem ipsum' ],
                    [ 'dc:alternative', 'Dolor sit amet' ],
                    [ 'dc:conformsTo', 'Rulebook 1' ],
                    [ 'dc:creator', 'Alice' ],
                    [ 'dc:accessRights', 'read' ],
                    [ 'dc:accessRights', 'modify' ],
                    [ 'dc:creator', 'Bob' ]
                ],
                [
                    [ 'dc:type', 'Software' ],
                    [ 'dc:creator', 'Charles' ],
                    [ 'dc:accessRights', 'publish' ],
                    [ 'dc:conformsTo', 'Rulebook 2' ],
                    [ 'dc:accessRights', 'delete' ],
                    [ 'dc:alternative', 'Consetetur sadipscing elitr' ],
                    [ 'dc:conformsTo', 'Rulebook 3' ],
                ],
                [
                    [ 'dc:title', 'Lorem ipsum' ],
                    [ 'dc:alternative', 'Consetetur sadipscing elitr' ],
                    [ 'dc:conformsTo', 'Rulebook 2' ],
                    [ 'dc:conformsTo', 'Rulebook 3' ],
                    [ 'dc:creator', 'Charles' ],
                    [ 'dc:accessRights', 'publish' ],
                    [ 'dc:accessRights', 'delete' ],
                    [ 'dc:type', 'Software' ]
                ]
            ]
        ];
    }

    public function testPropUrisToDelete(): void
    {
        $rdfaData1 = RdfaData::newFromIterable(
            [
                [ 'dc:title', 'Foo' ],
                [ 'dc:abstract', 'Lorem ipsum.' ],
                [ 'rdfs:comment', 'At vero eos et accusam et justo duo.' ],
                [ 'owl:sameAs', 'http://www.example.com/foo' ],
                [ 'dc:coverage', '2000' ]
            ]
        );

        $this->assertSame(
            [
                'dc:title' => self::DC_NS . 'title',
                'dc:abstract' => self::DC_NS . 'abstract',
                'rdfs:comment' => self::RDFS_NS . 'comment',
                'owl:sameAs' => self::OWL_NS . 'sameAs',
                'dc:coverage' => self::DC_NS . 'coverage'
            ],
            $rdfaData1->getCurieToUri()
        );

        $rdfaData1->getPropUrisToDelete()->add(
            self::DC_NS . 'creator',
            self::DC_NS . 'publisher',
        );

        $this->assertEquals(
            new Set([ self::DC_NS . 'creator', self::DC_NS . 'publisher' ]),
            $rdfaData1->getPropUrisToDelete()
        );

        $rdfaData2 = RdfaData::newFromIterable(
            [
                [ 'dc:creator', 'Bob' ]
            ]
        );

        $rdfaData2->getPropUrisToDelete()->add(
            self::DC_NS . 'title',
            self::RDFS_NS . 'comment',
            self::DC_NS . 'coverage'
        );

        $this->assertEquals(
            new Set(
                [
                    self::DC_NS . 'title',
                    self::RDFS_NS . 'comment',
                    self::DC_NS . 'coverage'
                ]
            ),
            $rdfaData2->getPropUrisToDelete()
        );

        $rdfaData3 = RdfaData::newFromIterable(
            [
                [ 'dc:coverage', '2026' ],
                [ 'dc:abstract', 'Stet clita kasd gubergren.' ],
            ]
        );

        $rdfaData3->getPropUrisToDelete()->add(
            self::DC_NS . 'modified'
        );

        $rdfaData2->add($rdfaData3);

        $this->assertEquals(
            new Set(
                [
                    self::DC_NS . 'title',
                    self::RDFS_NS . 'comment',
                    self::DC_NS . 'modified'
                ]
            ),
            $rdfaData2->getPropUrisToDelete()
        );

        $rdfaData1->replace($rdfaData2);

        $this->assertEquals(
            new Set([ self::DC_NS . 'publisher' ]),
            $rdfaData1->getPropUrisToDelete()
        );

        $rdfaData1->getPropUrisToDelete()->clear();

        $this->assertEquals(
            RdfaData::newFromIterable(
                [
                    [ 'dc:abstract', 'Stet clita kasd gubergren.' ],
                    [ 'owl:sameAs', 'http://www.example.com/foo' ],
                    [ 'dc:coverage', '2026' ],
                    [ 'dc:creator', 'Bob' ]
                ]
            ),
            $rdfaData1
        );

        $this->assertSame(
            [
                'dc:creator' => self::DC_NS . 'creator',
                'dc:coverage' => self::DC_NS . 'coverage',
                'dc:abstract' => self::DC_NS . 'abstract',
                'owl:sameAs' => self::OWL_NS . 'sameAs'
            ],
            $rdfaData1->getCurieToUri()
        );
    }

    /**
     * @dataProvider createNamespaceMapProvider
     */
    public function testCreateNamespaceMap($inputData, $expectedMap): void
    {
        $rdfaData = RdfaData::newFromIterable($inputData);

        $this->assertSame($expectedMap, $rdfaData->createNamespaceMap());
    }

    public function createNamespaceMapProvider(): array
    {
        return [
            [
                [
                    [ 'dc:title', 'Lorem ipsum' ],
                    [ 'dc:creator', 'Alice' ],
                    [ 'dc:creator', 'Bob' ],
                    [ 'dc:type', 'Text' ],
                    [ 'http:expires', 'P1D' ]
                ],
                [
                    'dc' => AbstractDcStmt::DC_NS,
                    'http' => AbstractHttpStmt::HTTP_NS
                ]
            ]
        ];
    }

    public function testCreateNamespaceMapException(): void
    {
        $rdfaData = RdfaData::newFromIterable(
            [
                [
                    'dc:bar',
                    new SimpleStmt('https://example.com', 'dc', 'bar', 'qux')
                ],
                [ 'dc:title', 'Conflict' ]
            ]
        );

        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'namespace prefix "dc" denotes different namespaces "https://example.com" and "http://purl.org/dc/terms/"'
        );

        $rdfaData->createNamespaceMap();
    }
}

<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public const DC_NS = AbstractDcStmt::DC_NS;

    public const HTTP_NS = AbstractHttpStmt::HTTP_NS;

  /**
   * @dataProvider createStmtArrayFromIterableProvider
   */
    public function testCreateStmtArrayFromIterable(
        $inputData,
        $expectedData
    ): void {
        $factory = new Factory();

        $data = $factory->createStmtArrayFromIterable($inputData);

        $this->assertSame(count($expectedData), count($data));

        foreach ($expectedData as $prop => $expectedItems) {
            $this->assertSame(count($expectedItems), count($data[$prop]));

            foreach ($expectedItems as $key => $item) {
                if ($item instanceof Node) {
                    $this->assertEquals(
                        $item->getUri(),
                        $data[$prop][$key]->getUri()
                    );

                    $this->assertEquals(
                        $item->getRdfaData(),
                        $data[$prop][$key]->getRdfaData()
                    );
                } else {
                    $this->assertEquals($item, $data[$prop][$key]);
                }
            }
        }
    }

    public function createStmtArrayFromIterableProvider(): array
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
                    [ 'dc:created', '2025-10-21T17:17+02:00' ]
                ],
                [
                    'dc:title' => [
                        'Lorem ipsum dolor sit amet'
                            => new DcTitle('Lorem ipsum dolor sit amet')
                    ],
                    self::DC_NS . 'title' => [
                        'Lorem ipsum dolor sit amet'
                            => new DcTitle('Lorem ipsum dolor sit amet')
                    ],
                    'dc:conformsTo' => [
                        'https://semver.org/spec/v2.0.0.html'
                            => new DcConformsTo(
                                'https://semver.org/spec/v2.0.0.html',
                                RdfaData::newFromIterable(
                                    [
                                        [
                                            'dc:title',
                                            [
                                                new DcTitle('Semantic Versioning')
                                            ]
                                        ]
                                    ]
                                )
                            ),
                        'https://example.org/strict'
                        => new DcConformsTo('https://example.org/strict')
                    ],
                    self::DC_NS . 'conformsTo' => [
                        'https://semver.org/spec/v2.0.0.html'
                            => new DcConformsTo(
                                'https://semver.org/spec/v2.0.0.html',
                                RdfaData::newFromIterable(
                                    [
                                        [
                                            'dc:title',
                                            [
                                                new DcTitle('Semantic Versioning')
                                            ]
                                        ]
                                    ]
                                )
                            ),
                        'https://example.org/strict'
                        => new DcConformsTo('https://example.org/strict')
                    ],
                    'dc:created' => [
                        '2025-10-21T17:17:00+02:00'
                            => new DcCreated('2025-10-21T17:17+02:00')
                    ],
                    self::DC_NS . 'created' => [
                        '2025-10-21T17:17:00+02:00'
                            => new DcCreated('2025-10-21T17:17+02:00')
                    ]
                ],
            ],
            [
                [
                    [ 'http:content-length', 4711 ]
                ],
                [
                    'http:content-length' => [
                        '4711' => new HttpContentLength(4711)
                    ],
                    self::HTTP_NS . 'content-length' => [
                        '4711' => new HttpContentLength(4711)
                    ]
                ]
            ]
        ];
    }

    public function testCreateStmtArrayFromIterableException1(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'object property CURIE "dc:title" does not match key "dc:tittle"'
        );

        $factory = new Factory();

        $factory->createStmtArrayFromIterable(
            [ [ 'dc:tittle', new DcTitle('Lorem') ] ]
        );
    }

    public function testCreateStmtArrayFromIterableException2(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'object property CURIE "dc:title" does not match key "dc:alternative"'
        );

        $factory = new Factory();

        $factory->createStmtArrayFromIterable(
            [ [ 'dc:alternative', new DcTitle('Ipsum') ] ]
        );
    }
}

<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;
use PHPUnit\Framework\TestCase;

class RdfaDataTest extends TestCase
{
    public const DC_NS = AbstractDcStmt::DC_NS;

    /**
     * @dataProvider newFromIterableProvider
     */
    public function testNewFromIterable($inputData, $expectedData): void
    {
        $factory = new Factory();

        $rdfaData = RdfaData::newFromIterable($inputData);

        $this->assertSame(count($expectedData), count($rdfaData));

        foreach ($expectedData as $prop => $expectedItems) {
            $this->assertSame(count($expectedItems), count($rdfaData[$prop]));

            foreach ($expectedItems as $key => $item) {
                $this->assertEquals($item, $rdfaData[$prop][$key]);
            }
        }
    }

    public function newFromIterableProvider(): array
    {
        return [
            [
                [
                    [ 'dc:format', 'application/xml' ],
                    [ 'dc:creator', null ]
                ],
                [
                    'dc:format' => [ 'application/xml' => 'application/xml' ],
                    self::DC_NS . 'format'
                        => [ 'application/xml' => 'application/xml' ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($inputData1, $inputData2, $expectedData): void
    {
        $factory = new Factory();

        $rdfaData = RdfaData::newFromIterable($inputData1)
            ->add(RdfaData::newFromIterable($inputData2));

        $expectedArray =
            $factory->createStmtArrayFromIterable($expectedData);

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
        $factory = new Factory();

        $rdfaData = RdfaData::newFromIterable($inputData1)
            ->replace(RdfaData::newFromIterable($inputData2));

        $expectedArray =
            $factory->createStmtArrayFromIterable($expectedData);

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

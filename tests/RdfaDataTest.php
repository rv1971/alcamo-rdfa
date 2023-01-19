<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class RdfaDataTest extends TestCase
{
    /**
     * @dataProvider newFromIterableProvider
     */
    public function testNewFromIterable($inputData, $expectedData): void
    {
        $factory = new Factory();

        $rdfaData = RdfaData::newFromIterable($inputData);

        $expectedArray =
            $factory->createStmtArrayFromPropCurieMap($expectedData);

        $this->assertSame(count($expectedArray), count($rdfaData));

        foreach ($expectedArray as $key => $value) {
            $this->assertEquals($expectedArray[$key], $rdfaData[$key]);
        }
    }

    public function newFromIterableProvider(): array
    {
        return [
            [
                [ 'dc:format' => 'application/xml' ],
                [ 'dc:format' => 'application/xml' ]
            ],
            [
                [ 'dc:format' => 'application/xml; charset=US-ASCII' ],
                [
                    'dc:format' => 'application/xml; charset=US-ASCII',
                    'meta:charset' => 'US-ASCII'
                ]
            ],
            [
                [
                    'dc:format' => 'application/xml; charset=US-ASCII',
                    'meta:charset' => 'UTF-8'
                ],
                [
                    'dc:format' => 'application/xml; charset=US-ASCII',
                    'meta:charset' => 'UTF-8'
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
            $factory->createStmtArrayFromPropCurieMap($expectedData);

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
                    'dc:title' => 'Lorem ipsum',
                    'dc:alternative' => 'Dolor sit amet',
                    'dc:conformsTo' => 'Rulebook 1',
                    'dc:creator' => [ 'Alice', 'Bob' ],
                    'dc:accessRights' => [ 'read', 'modify' ]
                ],
                [
                    'dc:type' => 'Software',
                    'dc:creator' => 'Charles',
                    'dc:accessRights' => [ 'publish', 'delete' ],
                    'dc:alternative' => 'Consetetur sadipscing elitr',
                    'dc:conformsTo' => [ 'Rulebook 2', 'Rulebook 3' ]
                ],
                [
                    'dc:title' => 'Lorem ipsum',
                    'dc:alternative' =>
                    [ 'Dolor sit amet', 'Consetetur sadipscing elitr' ],
                    'dc:conformsTo' =>
                    [ 'Rulebook 1', 'Rulebook 2', 'Rulebook 3' ],
                    'dc:creator' => [ 'Alice', 'Bob', 'Charles' ],
                    'dc:accessRights' =>
                    [ 'read', 'modify', 'publish', 'delete' ],
                    'dc:type' => 'Software'
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
            $factory->createStmtArrayFromPropCurieMap($expectedData);

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
                    'dc:title' => 'Lorem ipsum',
                    'dc:alternative' => 'Dolor sit amet',
                    'dc:conformsTo' => 'Rulebook 1',
                    'dc:creator' => [ 'Alice', 'Bob' ],
                    'dc:accessRights' => [ 'read', 'modify' ]
                ],
                [
                    'dc:type' => 'Software',
                    'dc:creator' => 'Charles',
                    'dc:accessRights' => [ 'publish', 'delete' ],
                    'dc:alternative' => 'Consetetur sadipscing elitr',
                    'dc:conformsTo' => [ 'Rulebook 2', 'Rulebook 3' ]
                ],
                [
                    'dc:title' => 'Lorem ipsum',
                    'dc:alternative' => 'Consetetur sadipscing elitr',
                    'dc:conformsTo' => [ 'Rulebook 2', 'Rulebook 3' ],
                    'dc:creator' => 'Charles',
                    'dc:accessRights' => [ 'publish', 'delete' ],
                    'dc:type' => 'Software'
                ]
            ]
        ];
    }
}

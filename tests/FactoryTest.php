<?php

namespace alcamo\rdfa;

use alcamo\exception\DataValidationFailed;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
  /**
   * @dataProvider createStmtArrayFromPropCurieMapProvider
   */
    public function testCreateStmtArrayFromPropCurieMap(
        $inputData,
        $expectedData
    ): void {
        $factory = new Factory();

        $data = $factory->createStmtArrayFromPropCurieMap($inputData);

        $this->assertEquals($expectedData, $data);
    }

    public function createStmtArrayFromPropCurieMapProvider(): array
    {
        return [
            [
                [
                    'dc:title' => new DcTitle('Lorem ipsum dolorsit amet'),
                    'dc:conformsTo' => [
                        'https://semver.org/spec/v2.0.0.html',
                        'https://example.org/strict'
                    ],
                    'dc:created' => '2023-01-18T18:34+03:00',
                    'dc:publisher' => null
                ],
                [
                    'dc:title' => new DcTitle('Lorem ipsum dolorsit amet'),
                    'dc:conformsTo' => [
                        'https://semver.org/spec/v2.0.0.html'
                        => new DcConformsTo('https://semver.org/spec/v2.0.0.html'),
                        'https://example.org/strict'
                        => new DcConformsTo('https://example.org/strict')
                    ],
                    'dc:created' => new DcCreated('2023-01-18T18:34+03:00')
                ]
            ]
        ];
    }

    public function testCreateStmtArrayFromPropCurieMapException1(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'object property CURIE "dc:title" does not match key "dc:tittle"'
        );

        $factory = new Factory();

        $factory->createStmtArrayFromPropCurieMap(
            [
                'dc:tittle' => new DcTitle('Lorem')
            ]
        );
    }

    public function testCreateStmtArrayFromPropCurieMapException2(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'item property CURIE "dc:title" does not match key "dc:alternative"'
        );

        $factory = new Factory();

        $factory->createStmtArrayFromPropCurieMap(
            [
                'dc:alternative' => [ new DcTitle('Ipsum') ]
            ]
        );
    }

    public function testCreateStmtArrayFromPropCurieMapException3(): void
    {
        $this->expectException(DataValidationFailed::class);
        $this->expectExceptionMessage(
            'array given for unique ' . DcTitle::class
        );

        $factory = new Factory();

        $factory->createStmtArrayFromPropCurieMap(
            [
                'dc:title' => [ new DcTitle('Ipsum') ]
            ]
        );
    }
}

<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($uri, $rdfaData): void
    {
        $node = new Node($uri, $rdfaData);

        $this->assertSame($uri, $node->getUri());

        $this->assertEquals($rdfaData ?: null, $node->getRdfaData());

        if (isset($rdfaData)) {
            /* Test __clone(). */
            $this->assertNotSame($rdfaData, $node->getRdfaData());
        }

        $this->assertSame($uri, (string)$node);
    }

    public function basicsProvider(): array
    {
        return [
            [ 'https://www.example.org', null ],
            [
                'https://www.example.org/bob',
                RdfaData::newFromIterable(
                    [ [ 'dc:title', new DcTitle('About me') ] ]
                )
            ],
            [ 'https://www.example.org/Alice', [] ],
        ];
    }
}

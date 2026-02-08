<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class SimpleStmtTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics(
        $propNsName,
        $propNsPrefix,
        $propLocalName,
        $object
    ): void {
        $stmt = new SimpleStmt(
            $propNsName,
            $propNsPrefix,
            $propLocalName,
            $object
        );

        $this->assertSame($propNsName, $stmt->getPropNsName());

        $this->assertSame($propNsPrefix, $stmt->getPropNsPrefix());

        $this->assertSame($propLocalName, $stmt->getPropLocalName());

        $this->assertSame($propNsName . $propLocalName, $stmt->getPropUri());

        if (isset($propNsPrefix)) {
            $this->assertSame(
                $propNsPrefix . ':' . $propLocalName,
                $stmt->getPropCurie()
            );
        } else {
            $this->assertNull($stmt->getPropCurie());
        }

        $this->assertSame($object, $stmt->getObject());

        $this->assertSame((string)$object, (string)$stmt);
    }

    public function basicsProvider(): array
    {
        return [
            [ 'https://foo.example.com', 'foo', 'bar', 42 ],
            [ 'https://foo.example.com', null, 'baz', 43 ]
        ];
    }
}

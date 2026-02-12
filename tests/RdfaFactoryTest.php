<?php

namespace alcamo\rdfa;

use alcamo\xml\NamespaceConstantsInterface;
use PHPUnit\Framework\TestCase;

class RdfaFactoryTest extends TestCase implements NamespaceConstantsInterface
{
    /* Most functionality is tested in RdfaDataTest. */

    public function testCreateStmtFromUnknownUri(): void
    {
        $stmt = (new RdfaFactory())
            ->createStmtFromUriAndData('http://www.example.com/foo-bar', 'baz');

        $this->assertInstanceOf(SimpleStmt::class, $stmt);

        $this->assertSame('http://www.example.com/', $stmt->getPropNsName());

        $this->assertNull($stmt->getPropNsPrefix());

        $this->assertSame('foo-bar', $stmt->getPropLocalName());

        $this->assertSame(
            'http://www.example.com/foo-bar',
            $stmt->getPropUri()
        );

        $this->assertNull($stmt->getPropCurie());

        $this->assertEquals(new StringLiteral('baz'), $stmt->getObject());

        $this->assertSame('baz', (string)$stmt);
    }

    public function testCreateStmtFromUnknownNsPrefix(): void
    {
        $this->assertNull(
            (new RdfaFactory())->createStmtFromCurieAndData('foo:bar', 'baz')
        );
    }
}

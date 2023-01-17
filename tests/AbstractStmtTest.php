<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;

class AbstractStmtTest extends TestCase
{
    public const DC_NS = 'http://purl.org/dc/terms/';

    public const OWL_NS = 'http://www.w3.org/2002/07/owl#';

    public const HTTP_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:http#';

    public const META_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:meta#';

    public const REL_NS  = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:rel#';

    /**
     * @dataProvider basicsProvider
     */
    public function testBasics(
        $stmt,
        $expectedPropNsName,
        $expectedPropNsPrefix,
        $expectedPropLocalName,
        $expectedObject,
        $expectedIsNodeUri,
        $expectedString
    ): void {
        $this->assertSame($expectedPropNsName, $stmt->getPropNsName());

        $this->assertSame($expectedPropNsPrefix, $stmt->getPropNsPrefix());

        $this->assertSame($expectedPropLocalName, $stmt->getPropLocalName());

        $this->assertSame(
            $expectedPropNsName . $expectedPropLocalName,
            $stmt->getPropUri()
        );

        $this->assertSame(
            "$expectedPropNsPrefix:$expectedPropLocalName",
            $stmt->getPropCurie()
        );

        if (is_object($expectedObject)) {
            $this->assertInstanceOf(
                get_class($expectedObject),
                $stmt->getObject()
            );

            $this->assertEquals($expectedObject, $stmt->getObject());
        } else {
            $this->assertSame($expectedObject, $stmt->getObject());
        }

        $this->assertSame($expectedIsNodeUri, $stmt->isNodeUri());

        $this->assertSame($expectedString, (string)$stmt);
    }

    public function basicsProvider(): array
    {
        return [
            'DcAbstract-literal' => [
                new DcAbstract('Lorem ipsum.', false),
                self::DC_NS,
                'dc',
                'abstract',
                'Lorem ipsum.',
                false,
                'Lorem ipsum.'
            ],
            'DcAbstract-node' => [
                new DcAbstract('https://example.org/summary', true),
                self::DC_NS,
                'dc',
                'abstract',
                'https://example.org/summary',
                true,
                'https://example.org/summary'
            ],
            'DcAccessRights-literal' => [
                new DcAccessRights('confidential', false),
                self::DC_NS,
                'dc',
                'accessRights',
                'confidential',
                false,
                'confidential'
            ],
            'DcAccessRights-node' => [
                new DcAccessRights('https://example.org/access-rights', true),
                self::DC_NS,
                'dc',
                'accessRights',
                'https://example.org/access-rights',
                true,
                'https://example.org/access-rights'
            ],
            'DcAlternative' => [
                new DcAlternative('At vero eos'),
                self::DC_NS,
                'dc',
                'alternative',
                'At vero eos',
                false,
                'At vero eos'
            ],
            'DcAudience-literal' => [
                new DcAudience('customers', false),
                self::DC_NS,
                'dc',
                'audience',
                'customers',
                false,
                'customers'
            ],
            'DcAudience-node' => [
                new DcAudience('https://example.info/public', true),
                self::DC_NS,
                'dc',
                'audience',
                'https://example.info/public',
                true,
                'https://example.info/public'
            ],
            'DcConformsTo' => [
                new DcConformsTo('https://example.com/standards'),
                self::DC_NS,
                'dc',
                'conformsTo',
                'https://example.com/standards',
                true,
                'https://example.com/standards'
            ],
            'DcCreated' => [
                new DcCreated('2023-01-17T15:52:00+01:00'),
                self::DC_NS,
                'dc',
                'created',
                new \DateTime('2023-01-17T15:52:00+01:00'),
                false,
                '2023-01-17T15:52:00+01:00'
            ],
            'DcCreator-literal' => [
                new DcCreator('Alice', false),
                self::DC_NS,
                'dc',
                'creator',
                'Alice',
                false,
                'Alice'
            ],
            'DcCreator-node' => [
                new DcCreator('https://alice.example.org', true),
                self::DC_NS,
                'dc',
                'creator',
                'https://alice.example.org',
                true,
                'https://alice.example.org'
            ],
            'DcFormat' => [
                new DcFormat('application/xml'),
                self::DC_NS,
                'dc',
                'format',
                new MediaType('application', 'xml'),
                false,
                'application/xml'
            ]
        ];
    }
}

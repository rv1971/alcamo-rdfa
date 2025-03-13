<?php

namespace alcamo\rdfa;

use alcamo\exception\InvalidEnumerator;
use alcamo\time\Duration;
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

        $this->assertSame($expectedString, (string)$stmt);
    }

    public function basicsProvider(): array
    {
        return [
            'DcAbstract-literal' => [
                new DcAbstract('Lorem ipsum.'),
                self::DC_NS,
                'dc',
                'abstract',
                'Lorem ipsum.',
                'Lorem ipsum.'
            ],
            'DcAbstract-node' => [
                new DcAbstract(new Node('https://example.org/summary')),
                self::DC_NS,
                'dc',
                'abstract',
                new Node('https://example.org/summary'),
                'https://example.org/summary'
            ],
            'DcAccessRights-literal' => [
                new DcAccessRights('confidential'),
                self::DC_NS,
                'dc',
                'accessRights',
                'confidential',
                'confidential'
            ],
            'DcAccessRights-node' => [
                new DcAccessRights(
                    new Node('https://example.org/access-rights')
                ),
                self::DC_NS,
                'dc',
                'accessRights',
                new Node('https://example.org/access-rights'),
                'https://example.org/access-rights'
            ],
            'DcAlternative' => [
                new DcAlternative('At vero eos'),
                self::DC_NS,
                'dc',
                'alternative',
                'At vero eos',
                'At vero eos'
            ],
            'DcAudience-literal' => [
                new DcAudience('customers'),
                self::DC_NS,
                'dc',
                'audience',
                'customers',
                'customers'
            ],
            'DcAudience-node' => [
                new DcAudience(new Node('https://example.info/public')),
                self::DC_NS,
                'dc',
                'audience',
                new Node('https://example.info/public'),
                'https://example.info/public'
            ],
            'DcConformsTo' => [
                new DcConformsTo('https://example.com/standards'),
                self::DC_NS,
                'dc',
                'conformsTo',
                new Node('https://example.com/standards'),
                'https://example.com/standards'
            ],
            'DcCoverage' => [
                new DcCoverage('Akureyri'),
                self::DC_NS,
                'dc',
                'coverage',
                'Akureyri',
                'Akureyri'
            ],
            'DcCreated' => [
                new DcCreated('2023-01-17T15:52:00+01:00'),
                self::DC_NS,
                'dc',
                'created',
                new \DateTime('2023-01-17T15:52:00+01:00'),
                '2023-01-17T15:52:00+01:00'
            ],
            'DcCreator-literal' => [
                new DcCreator('Alice'),
                self::DC_NS,
                'dc',
                'creator',
                'Alice',
                'Alice'
            ],
            'DcCreator-node' => [
                new DcCreator(new Node('https://alice.example.org')),
                self::DC_NS,
                'dc',
                'creator',
                new Node('https://alice.example.org'),
                'https://alice.example.org'
            ],
            'DcFormat' => [
                new DcFormat('application/xml'),
                self::DC_NS,
                'dc',
                'format',
                new MediaType('application', 'xml'),
                'application/xml'
            ],
            'DcIdentifier' => [
                new DcIdentifier('foo-bar'),
                self::DC_NS,
                'dc',
                'identifier',
                'foo-bar',
                'foo-bar'
            ],
            'DcLanguage' => [
                new DcLanguage('es-MX'),
                self::DC_NS,
                'dc',
                'language',
                Lang::newFromPrimaryAndRegion('es', 'MX'),
                'es-MX'
            ],
            'DcModified' => [
                new DcModified('2023-01-18Z'),
                self::DC_NS,
                'dc',
                'modified',
                new \DateTime('2023-01-18Z'),
                '2023-01-18T00:00:00+00:00'
            ],
            'DcPublisher-literal' => [
                new DcPublisher('Bob'),
                self::DC_NS,
                'dc',
                'publisher',
                'Bob',
                'Bob'
            ],
            'DcPublisher-node' => [
                new DcPublisher(new Node('https://bob.example.org')),
                self::DC_NS,
                'dc',
                'publisher',
                new Node('https://bob.example.org'),
                'https://bob.example.org'
            ],
            'DcRights-literal' => [
                new DcRights('(C) Example ltd. 2023'),
                self::DC_NS,
                'dc',
                'rights',
                '(C) Example ltd. 2023',
                '(C) Example ltd. 2023'
            ],
            'DcRights-node' => [
                new DcRights(new Node('https://example.org/rights')),
                self::DC_NS,
                'dc',
                'rights',
                new Node('https://example.org/rights'),
                'https://example.org/rights'
            ],
            'DcSource' => [
                new DcSource('https://example.com/42'),
                self::DC_NS,
                'dc',
                'source',
                new Node('https://example.com/42'),
                'https://example.com/42'
            ],
            'DcTitle' => [
                new DcTitle('Lorem ipsum'),
                self::DC_NS,
                'dc',
                'title',
                'Lorem ipsum',
                'Lorem ipsum'
            ],
            'DcType' => [
                new DcType('Sound'),
                self::DC_NS,
                'dc',
                'type',
                'Sound',
                'Sound'
            ],
            'HttpCacheControl' => [
                new HttpCacheControl('public'),
                self::HTTP_NS,
                'http',
                'cache-control',
                'public',
                'public'
            ],
            'HttpContentDisposition' => [
                new HttpContentDisposition('qux.json'),
                self::HTTP_NS,
                'http',
                'content-disposition',
                'qux.json',
                'qux.json'
            ],
            'HttpContentLength' => [
                new HttpContentLength(1024),
                self::HTTP_NS,
                'http',
                'content-length',
                1024,
                '1024'
            ],
            'HttpExpires' => [
                new HttpExpires('P40D'),
                self::HTTP_NS,
                'http',
                'expires',
                new Duration('P40D'),
                'P40D'
            ],
            'MetaCharset' => [
                new MetaCharset('ASCII'),
                self::META_NS,
                'meta',
                'charset',
                'ASCII',
                'ASCII'
            ],
            'OwlVersionInfo' => [
                new OwlVersionInfo('1.2.3'),
                self::OWL_NS,
                'owl',
                'versionInfo',
                '1.2.3',
                '1.2.3'
            ],
            'RelContents' => [
                new RelContents('index.php'),
                self::REL_NS,
                'rel',
                'contents',
                new Node('index.php'),
                'index.php'
            ],
            'RelHome' => [
                new RelHome('../..'),
                self::REL_NS,
                'rel',
                'home',
                new Node('../..'),
                '../..'
            ],
            'RelUp' => [
                new RelUp('..'),
                self::REL_NS,
                'rel',
                'up',
                new Node('..'),
                '..'
            ]
        ];
    }

    public function testDcTypeException(): void
    {
        $this->expectException(InvalidEnumerator::class);
        $this->expectExceptionMessage(
            'Invalid value "foo", expected one of ["Collection", "Dataset", '
        );

        new DcType('foo');
    }
}

<?php

namespace alcamo\rdfa;

use alcamo\exception\InvalidEnumerator;
use alcamo\time\Duration;
use alcamo\xml\NamespaceConstantsInterface;
use PHPUnit\Framework\TestCase;

class StmtTest extends TestCase implements NamespaceConstantsInterface
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics(
        $stmt,
        $expectedPropNsName,
        $expectedPropNsPrefix,
        $expectedPropLocalName,
        $expectedObject,
        $expectedString,
        $expectedDigest
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

        switch (true) {
            case is_object($expectedObject):
                $this->assertInstanceOf(
                    get_class($expectedObject),
                    $stmt->getObject()
                );

                $this->assertEquals($expectedObject, $stmt->getObject());

                break;

            case is_string($expectedObject):
                $this->assertSame($expectedObject, (string)$stmt->getObject());
                break;

            default:
                $this->assertSame($expectedObject, $stmt->getObject()->getValue());
        }

        $this->assertSame($expectedString, (string)$stmt);

        $this->assertSame($expectedDigest, $stmt->getDigest());
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
                'Lorem ipsum.',
                'Lorem ipsum.'
            ],
            'DcAbstract-node' => [
                new DcAbstract(
                    new Node(
                        'https://example.org/summary',
                        RdfaData::newFromIterable(
                            [ [ 'dc:type', new DcType('Text') ] ]
                        )
                    )
                ),
                self::DC_NS,
                'dc',
                'abstract',
                new Node(
                    'https://example.org/summary',
                    RdfaData::newFromIterable(
                        [ [ 'dc:type', new DcType('Text') ] ]
                    )
                ),
                'https://example.org/summary',
                'https://example.org/summary'
            ],
            'DcAccessRights-literal' => [
                new DcAccessRights('confidential'),
                self::DC_NS,
                'dc',
                'accessRights',
                'confidential',
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
                'https://example.org/access-rights',
                'https://example.org/access-rights'
            ],
            'DcAlternative' => [
                new DcAlternative('At vero eos'),
                self::DC_NS,
                'dc',
                'alternative',
                'At vero eos',
                'At vero eos',
                '"At vero eos"'
            ],
            'DcAudience-literal' => [
                new DcAudience('customers'),
                self::DC_NS,
                'dc',
                'audience',
                'customers',
                'customers',
                'customers'
            ],
            'DcAudience-node' => [
                new DcAudience(new Node('https://example.info/public')),
                self::DC_NS,
                'dc',
                'audience',
                new Node('https://example.info/public'),
                'https://example.info/public',
                'https://example.info/public'
            ],
            'DcConformsTo' => [
                new DcConformsTo('https://example.com/standards'),
                self::DC_NS,
                'dc',
                'conformsTo',
                new Node('https://example.com/standards'),
                'https://example.com/standards',
                'https://example.com/standards'
            ],
            'DcCoverage' => [
                new DcCoverage('Akureyri'),
                self::DC_NS,
                'dc',
                'coverage',
                'Akureyri',
                'Akureyri',
                'Akureyri'
            ],
            'DcCreated' => [
                new DcCreated('2023-01-17T15:52:00+01:00'),
                self::DC_NS,
                'dc',
                'created',
                new DateTimeLiteral('2023-01-17T15:52:00+01:00'),
                '2023-01-17T15:52:00+01:00',
                '2023-01-17T15:52:00+01:00'
            ],
            'DcCreator-literal' => [
                new DcCreator('Alice'),
                self::DC_NS,
                'dc',
                'creator',
                'Alice',
                'Alice',
                'Alice'
            ],
            'DcCreator-node' => [
                new DcCreator(new Node('https://alice.example.org')),
                self::DC_NS,
                'dc',
                'creator',
                new Node('https://alice.example.org'),
                'https://alice.example.org',
                'https://alice.example.org'
            ],
            'DcDate' => [
                new DcDate('2025-03-16T22:13:16+01:00'),
                self::DC_NS,
                'dc',
                'date',
                new DateTimeLiteral('2025-03-16T22:13:16+01:00'),
                '2025-03-16T22:13:16+01:00',
                '2025-03-16T22:13:16+01:00'
            ],
            'DcFormat' => [
                new DcFormat('application/xml'),
                self::DC_NS,
                'dc',
                'format',
                new MediaType('application', 'xml'),
                'application/xml',
                'application/xml'
            ],
            'DcIdentifier' => [
                new DcIdentifier('foo-bar'),
                self::DC_NS,
                'dc',
                'identifier',
                'foo-bar',
                'foo-bar',
                'foo-bar'
            ],
            'DcLanguage' => [
                new DcLanguage('es-MX'),
                self::DC_NS,
                'dc',
                'language',
                new LanguageLiteral(Lang::newFromPrimaryAndRegion('es', 'MX')),
                'es-MX',
                'es-MX'
            ],
            'DcModified' => [
                new DcModified('2023-01-18Z'),
                self::DC_NS,
                'dc',
                'modified',
                new DateTimeLiteral('2023-01-18Z'),
                '2023-01-18T00:00:00+00:00',
                '2023-01-18T00:00:00+00:00'
            ],
            'DcPublisher-literal' => [
                new DcPublisher('Bob'),
                self::DC_NS,
                'dc',
                'publisher',
                'Bob',
                'Bob',
                'Bob'
            ],
            'DcPublisher-node' => [
                new DcPublisher(new Node('https://bob.example.org')),
                self::DC_NS,
                'dc',
                'publisher',
                new Node('https://bob.example.org'),
                'https://bob.example.org',
                'https://bob.example.org'
            ],
            'DcRights-literal' => [
                new DcRights('(C) Example ltd. 2023'),
                self::DC_NS,
                'dc',
                'rights',
                '(C) Example ltd. 2023',
                '(C) Example ltd. 2023',
                '(C) Example ltd. 2023'
            ],
            'DcRights-node' => [
                new DcRights(new Node('https://example.org/rights')),
                self::DC_NS,
                'dc',
                'rights',
                new Node('https://example.org/rights'),
                'https://example.org/rights',
                'https://example.org/rights'
            ],
            'DcSource' => [
                new DcSource('https://example.com/42'),
                self::DC_NS,
                'dc',
                'source',
                new Node('https://example.com/42'),
                'https://example.com/42',
                'https://example.com/42'
            ],
            'DcTitle' => [
                new DcTitle('Lorem ipsum'),
                self::DC_NS,
                'dc',
                'title',
                'Lorem ipsum',
                'Lorem ipsum',
                '"Lorem ipsum"'
            ],
            'DcType' => [
                new DcType('Sound'),
                self::DC_NS,
                'dc',
                'type',
                'Sound',
                'Sound',
                'Sound'
            ],
            'HttpCacheControl' => [
                new HttpCacheControl('public'),
                self::HTTP_NS,
                'http',
                'cache-control',
                'public',
                'public',
                'public'
            ],
            'HttpContentDisposition' => [
                new HttpContentDisposition('qux.json'),
                self::HTTP_NS,
                'http',
                'content-disposition',
                'qux.json',
                'qux.json',
                'qux.json'
            ],
            'HttpContentLength' => [
                new HttpContentLength(1024),
                self::HTTP_NS,
                'http',
                'content-length',
                1024,
                '1024',
                '1024'
            ],
            'HttpExpires' => [
                new HttpExpires('P40D'),
                self::HTTP_NS,
                'http',
                'expires',
                new DurationLiteral('P40D'),
                'P40D',
                'P40D'
            ],
            'OwlVersionInfo' => [
                new OwlVersionInfo('1.2.3'),
                self::OWL_NS,
                'owl',
                'versionInfo',
                '1.2.3',
                '1.2.3',
                '1.2.3'
            ],
            'OwlSameAs' => [
                new OwlSameAs('https://owl.example.org/42'),
                self::OWL_NS,
                'owl',
                'sameAs',
                new Node('https://owl.example.org/42'),
                'https://owl.example.org/42',
                'https://owl.example.org/42'
            ],
            'RdfsLabel' => [
                new RdfsLabel(new LangStringLiteral('example', 'en-IE')),
                self::RDFS_NS,
                'rdfs',
                'label',
                new LangStringLiteral('example', 'en-IE'),
                'example',
                '"example"@en-IE'
            ],
            'RdfsComment' => [
                new RdfsComment('Lorem ipsum'),
                self::RDFS_NS,
                'rdfs',
                'comment',
                'Lorem ipsum',
                'Lorem ipsum',
                '"Lorem ipsum"'
            ],
            'RdfsSeeAlso' => [
                new RdfsSeeAlso('http://www.example.info'),
                self::RDFS_NS,
                'rdfs',
                'seeAlso',
                new Node('http://www.example.info'),
                'http://www.example.info',
                'http://www.example.info'
            ],
            'XhvContents' => [
                new XhvMetaStmt('contents', 'index.php'),
                self::XHV_NS,
                'xhv',
                'contents',
                new Node('index.php'),
                'index.php',
                'index.php'
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

<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;
use alcamo\ietf\Uri as AlcamoUri;
use GuzzleHttp\Psr7\Uri;

class RelHomeTest extends TestCase
{
    public function testBasics()
    {
        $uri = 'https://home.example.org';

        $relHome = new RelHome($uri);

        $this->assertSame('rel:home', $relHome->getPropertyCurie());

        $this->assertSame(
            'tag:rv1971@web.de,2021:alcamo-rdfa:ns:rel#home',
            $relHome->getPropertyUri()
        );

        $this->assertSame(
            [
                'rel' => 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:rel#'
            ],
            $relHome->getPrefixMap()
        );

        $this->assertEquals(new Uri($uri), $relHome->getObject());

        $this->assertTrue($relHome->isResource());

        $this->assertSame('Home', $relHome->getResourceLabel());

        $this->assertSame((string)$uri, (string)$relHome);

        $this->assertSame(
            [
                'rel' => 'home',
                'href' => (string)$uri
            ],
            $relHome->toHtmlAttrs()
        );

        $relHome2 = new RelHome(new AlcamoUri($uri));

        $this->assertEquals(
            new AlcamoUri($uri),
            $relHome2->getObject()
        );
    }
}

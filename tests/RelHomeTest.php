<?php

namespace alcamo\rdfa;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Uri;

class RelHomeTest extends TestCase
{
    public function testBasics()
    {
        $uri = new Uri('https://home.example.org');

        $relHome = new RelHome($uri);

        $this->assertSame('rel:home', $relHome->getPropertyCurie());

        $this->assertSame(
            'tag:https://github.com/rv1971/alcamo-rdfa,2021:ns:rel#home',
            $relHome->getPropertyUri()
        );

        $this->assertSame(
            [
                'rel'
                => 'tag:https://github.com/rv1971/alcamo-rdfa,2021:ns:rel#'
            ],
            $relHome->getPrefixMap()
        );

        $this->assertSame($uri, $relHome->getObject());

        $this->assertTrue($relHome->isResource());

        $this->assertSame('Home', $relHome->getResourceLabel());

        $this->assertSame((string)$uri, (string)$relHome);
    }
}

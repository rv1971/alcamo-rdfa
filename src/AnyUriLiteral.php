<?php

namespace alcamo\rdfa;

use alcamo\uri\Uri;
use Psr\Http\Message\UriInterface;

/**
 * @brief RDFa anyURI literal
 *
 * @date Last reviewed 2026-02-18
 */
class AnyUriLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'anyURI';

    /**
     * @param $value UriInterface|string UriInterface or URI string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof UriInterface ? $value : new Uri($value),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

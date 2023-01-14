<?php

namespace alcamo\rdfa;

use alcamo\time\Duration;

/**
 * @brief expires RDFa statement
 *
 * @sa [Expires](http://tools.ietf.org/html/rfc2616#section-14.21)
 */
class HttpExpires extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::HTTP_NS . 'expires';

    public const CANONICAL_PROPERTY_CURIE = 'header:expires';

    public const OBJECT_CLASS = Duration::class;

    public function __construct(Duration $duration)
    {
        parent::__construct($duration);
    }
}

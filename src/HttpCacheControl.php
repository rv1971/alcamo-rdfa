<?php

namespace alcamo\rdfa;

/**
 * @brief cache-control RDFa statement
 *
 * @sa [Caching](https://tools.ietf.org/html/rfc7234)
 */
class HttpCacheControl extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::HTTP_NS . 'cache-control';

    public const CANONICAL_PROPERTY_CURIE = 'http:cache-control';
}

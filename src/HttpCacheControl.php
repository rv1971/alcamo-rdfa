<?php

namespace alcamo\rdfa;

/**
 * @brief cache-control RDFa statement
 *
 * @sa [Caching](https://tools.ietf.org/html/rfc7234)
 */
class HttpCacheControl extends AbstractLiteralStmt
{
    public const PROP_NS_NAME = self::HTTP_NS;

    public const PROP_NS_PREFIX = 'http';

    public const PROP_LOCAL_NAME = 'cache-control';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief cache-control RDFa statement
 *
 * @sa [Caching](https://datatracker.ietf.org/doc/html/rfc7234#section-5.2)
 *
 * @date Last reviewed 2025-10-19
 */
class HttpCacheControl extends AbstractHttpStmt
{
    public const PROP_LOCAL_NAME = 'cache-control';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const IS_ONCE_ONLY = true;
}

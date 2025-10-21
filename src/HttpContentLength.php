<?php

namespace alcamo\rdfa;

/**
 * @brief content-length RDFa statement
 *
 * @sa [Content-Length](https://datatracker.ietf.org/doc/html/rfc2616#section-14.13)
 *
 * @date Last reviewed 2025-10-18
 */
class HttpContentLength extends AbstractHttpStmt
{
    public const PROP_LOCAL_NAME = 'content-length';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const IS_ONCE_ONLY = true;

    public function __construct(int $length)
    {
        parent::__construct($length);
    }
}

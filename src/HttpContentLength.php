<?php

namespace alcamo\rdfa;

/**
 * @brief content-length RDFa statement
 *
 * @sa [Content-Length](http://tools.ietf.org/html/rfc2616#section-14.13)
 */
class HttpContentLength extends AbstractStmt
{
    public const PROP_NS_NAME = self::HTTP_NS;

    public const PROP_NS_PREFIX = 'http';

    public const PROP_LOCAL_NAME = 'content-length';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;

    public function __construct(int $length)
    {
        parent::__construct($length);
    }

    /// Create as size of file
    public static function newFromFilename($filename)
    {
        return new static(filesize($filename));
    }
}

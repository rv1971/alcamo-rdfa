<?php

namespace alcamo\rdfa;

/**
 * @brief content-length RDFa statement
 *
 * @sa [Content-Length](http://tools.ietf.org/html/rfc2616#section-14.13)
 */
class HttpContentLength extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::HTTP_NS . 'content-length';

    public const CANONICAL_PROPERTY_CURIE = 'http:content-length';

    /// Create as size of file
    public static function newFromFilename($filename)
    {
        return new static(filesize($filename));
    }
}

<?php

namespace alcamo\rdfa;

/**
 * @brief content-disposition RDFa statement
 *
 * @sa [Content-Disposition](http://tools.ietf.org/html/rfc2616#section-19.5.1)
 *
 * If used, the statement object is the filename suggested for saving the
 * attachment.
 */
class HttpContentDisposition extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::HTTP_NS . 'content-disposition';

    public const CANONICAL_PROPERTY_CURIE = 'http:content-disposition';
}

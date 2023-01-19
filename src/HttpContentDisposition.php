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
class HttpContentDisposition extends AbstractStmt
{
    public const PROP_NS_NAME = self::HTTP_NS;

    public const PROP_NS_PREFIX = 'http';

    public const PROP_LOCAL_NAME = 'content-disposition';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;
}

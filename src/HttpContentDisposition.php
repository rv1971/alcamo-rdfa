<?php

namespace alcamo\rdfa;

/**
 * @brief content-disposition RDFa statement
 *
 * @sa [Content-Disposition](https://datatracker.ietf.org/doc/html/rfc2616#section-19.5.1)
 *
 * If used, the statement object is the filename suggested for saving the
 * attachment.
 *
 * @date Last reviewed 2025-10-19
 */
class HttpContentDisposition extends AbstractHttpStmt
{
    public const PROP_LOCAL_NAME = 'content-disposition';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const IS_ONCE_ONLY = true;
}

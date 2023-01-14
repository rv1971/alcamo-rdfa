<?php

namespace alcamo\rdfa;

/**
 * @brief dc:modified RDFa statement
 *
 * @sa [dc:modified](http://purl.org/dc/terms/modified).
 */
class DcModified extends AbstractDateTimeObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'modified';

    public const CANONICAL_PROPERTY_CURIE = 'dc:modified';
}

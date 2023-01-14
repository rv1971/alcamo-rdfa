<?php

namespace alcamo\rdfa;

/**
 * @brief dc:source RDFa statement
 *
 * @sa [dc:source](http://purl.org/dc/terms/source).
 */
class DcSource extends AbstractResourceObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'source';

    public const CANONICAL_PROPERTY_CURIE = 'dc:source';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:conformsTo RDFa statement
 *
 * @sa [dc:conformsTo](http://purl.org/dc/terms/conformsTo).
 */
class DcConformsTo extends AbstractResourceObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'conformsTo';

    public const CANONICAL_PROPERTY_CURIE = 'dc:conformsTo';
}

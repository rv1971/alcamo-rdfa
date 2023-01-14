<?php

namespace alcamo\rdfa;

/**
 * @brief dc:rights RDFa statement
 *
 * @sa [dc:rights](http://purl.org/dc/terms/rights).
 */
class DcRights extends AbstractStmt
{
    public const PROPERTY_URI = self::DC_NS . 'rights';

    public const CANONICAL_PROPERTY_CURIE = 'dc:rights';
}

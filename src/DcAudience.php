<?php

namespace alcamo\rdfa;

/**
 * @brief dc:audience RDFa statement
 *
 * @sa [dc:audience](http://purl.org/dc/terms/audience).
 */
class DcAudience extends AbstractStmt
{
    public const PROPERTY_URI = self::DC_NS . 'audience';

    public const CANONICAL_PROPERTY_CURIE = 'dc:audience';
}

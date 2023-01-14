<?php

namespace alcamo\rdfa;

/**
 * @brief dc:creator RDFa statement
 *
 * @sa [dc:creator](http://purl.org/dc/terms/creator)
 */
class DcCreator extends AbstractStmt
{
    public const PROPERTY_URI = self::DC_NS . 'creator';

    public const CANONICAL_PROPERTY_CURIE = 'dc:creator';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:publisher RDFa statement
 *
 * @sa [dc:publisher](http://purl.org/dc/terms/publisher).
 */
class DcPublisher extends AbstractStmt
{
    public const PROPERTY_URI = self::DC_NS . 'publisher';

    public const CANONICAL_PROPERTY_CURIE = 'dc:publisher';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:created RDFa statement
 *
 * @sa [dc:created](http://purl.org/dc/terms/created).
 */
class DcCreated extends AbstractDateTimeObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'created';

    public const CANONICAL_PROPERTY_CURIE = 'dc:created';
}

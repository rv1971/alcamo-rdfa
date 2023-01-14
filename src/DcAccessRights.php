<?php

namespace alcamo\rdfa;

/**
 * @brief dc:accessRights RDFa statement
 *
 * @sa [dc:accessRights](http://purl.org/dc/terms/accessRights).
 */
class DcAccessRights extends AbstractStmt
{
    public const PROPERTY_URI = self::DC_NS . 'accessRights';

    public const CANONICAL_PROPERTY_CURIE = 'dc:accessRights';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:identifier RDFa statement
 *
 * @sa [dc:identifier](http://purl.org/dc/terms/identifier).
 */
class DcIdentifier extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'identifier';

    public const PROPERTY_CURIE = 'dc:identifier';
}

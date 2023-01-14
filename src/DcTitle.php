<?php

namespace alcamo\rdfa;

/**
 * @brief dc:title RDFa statement
 *
 * @sa [dc:title](http://purl.org/dc/terms/title).
 */
class DcTitle extends AbstractStmt
{
    use LiteralContentTrait;

    public const PROPERTY_URI = self::DC_NS . 'title';

    public const CANONICAL_PROPERTY_CURIE = 'dc:title';
}

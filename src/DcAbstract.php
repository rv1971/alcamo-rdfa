<?php

namespace alcamo\rdfa;

/**
 * @brief dc:abstract RDFa statement
 *
 * @sa [dc:abstract](http://purl.org/dc/terms/abstract).
 */
class DcAbstract extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::DC_NS . 'abstract';

    public const CANONICAL_PROPERTY_CURIE = 'dc:abstract';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:identifier RDFa statement
 *
 * @sa [dc:identifier](http://purl.org/dc/terms/identifier).
 *
 * @date Last reviewed 2021-06-21
 */
class DcIdentifier extends AbstractStmt
{
    use LiteralContentTrait;

    public const PROPERTY_CURIE = 'dc:identifier';
}

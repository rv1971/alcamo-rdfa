<?php

namespace alcamo\rdfa;

/**
 * @brief dc:conformsTo RDFa statement
 *
 * @sa [dc:conformsTo](http://purl.org/dc/terms/conformsTo).
 *
 * @date Last reviewed 2021-06-18
 */
class DcConformsTo extends AbstractStmt
{
    use ResourceObjectTrait;

    public const PROPERTY_CURIE = 'dc:conformsTo';
}

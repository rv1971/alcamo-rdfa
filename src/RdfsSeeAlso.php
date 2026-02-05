<?php

namespace alcamo\rdfa;

/**
 * @brief rdfs:seeAlso RDFa statement
 *
 * @sa [rdfs:seeAlso](https://www.w3.org/TR/rdf-schema/#ch_seealso)
 *
 * @date Last reviewed 2026-02-05
 */
class RdfsSeeAlso extends AbstractRdfsStmt
{
    use NodeStmtTrait;

    public const PROP_LOCAL_NAME = 'seeAlso';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

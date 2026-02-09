<?php

namespace alcamo\rdfa;

/**
 * @brief rdfs:label RDFa statement
 *
 * @sa [rdfs:label](https://www.w3.org/TR/rdf-schema/#ch_label)
 *
 * @date Last reviewed 2026-02-05
 */
class RdfsLabel extends AbstractRdfsStmt
{
    use FixedLiteralTypeStmtTrait;

    public const PROP_LOCAL_NAME = 'label';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const LITERAL_CLASS = LangStringLiteral::class;
}

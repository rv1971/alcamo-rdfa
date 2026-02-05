<?php

namespace alcamo\rdfa;

/**
 * @brief rdfs:comment RDFa statement
 *
 * @sa [rdfs:comment](https://www.w3.org/TR/rdf-schema/#ch_comment)
 *
 * @date Last reviewed 2026-02-05
 */
class RdfsComment extends AbstractRdfsStmt
{
    use FixedLiteralStmtTrait;

    public const PROP_LOCAL_NAME = 'comment';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const LITERAL_CLASS = LangStringLiteral::class;
}

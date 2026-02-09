<?php

namespace alcamo\rdfa;

/**
 * @brief dc:title RDFa statement
 *
 * @sa [dc:title](http://purl.org/dc/terms/title).
 *
 * @date Last reviewed 2025-10-19
 */
class DcTitle extends AbstractDcStmt
{
    use FixedLiteralTypeStmtTrait;

    public const PROP_LOCAL_NAME = 'title';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const LITERAL_CLASS = LangStringLiteral::class;
}

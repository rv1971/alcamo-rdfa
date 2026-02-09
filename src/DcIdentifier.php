<?php

namespace alcamo\rdfa;

/**
 * @brief dc:identifier RDFa statement
 *
 * @sa [dc:identifier](http://purl.org/dc/terms/identifier).
 *
 * @date Last reviewed 2025-10-19
 */
class DcIdentifier extends AbstractDcStmt
{
    use FixedLiteralTypeStmtTrait;

    public const PROP_LOCAL_NAME = 'identifier';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    /// Objects are language-agnostic
    public const LITERAL_CLASS = StringLiteral::class;
}

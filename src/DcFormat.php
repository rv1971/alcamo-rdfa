<?php

namespace alcamo\rdfa;

/**
 * @brief dc:format RDFa statement
 *
 * @sa [dc:format](http://purl.org/dc/terms/format).
 *
 * @date Last reviewed 2025-10-19
 */
class DcFormat extends AbstractDcStmt
{
    use FixedLiteralTypeStmtTrait;

    public const PROP_LOCAL_NAME = 'format';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const LITERAL_CLASS = MediaTypeLiteral::class;
}

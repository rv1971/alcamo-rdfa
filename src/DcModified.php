<?php

namespace alcamo\rdfa;

/**
 * @brief dc:modified RDFa statement
 *
 * @sa [dc:modified](http://purl.org/dc/terms/modified).
 *
 * @date Last reviewed 2025-10-19
 */
class DcModified extends AbstractDcStmt
{
    use DateTimeStmtTrait;

    public const PROP_LOCAL_NAME = 'modified';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:conformsTo RDFa statement
 *
 * @sa [dc:conformsTo](http://purl.org/dc/terms/conformsTo).
 *
 * @date Last reviewed 2025-10-19
 */
class DcConformsTo extends AbstractDcStmt
{
    use NodeStmtTrait;

    public const PROP_LOCAL_NAME = 'conformsTo';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

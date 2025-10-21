<?php

namespace alcamo\rdfa;

/**
 * @brief dc:source RDFa statement
 *
 * @sa [dc:source](http://purl.org/dc/terms/source).
 *
 * @date Last reviewed 2025-10-19
 */
class DcSource extends AbstractDcStmt
{
    use NodeStmtTrait;

    public const PROP_LOCAL_NAME = 'source';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

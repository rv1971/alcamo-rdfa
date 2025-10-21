<?php

namespace alcamo\rdfa;

/**
 * @brief dc:created RDFa statement
 *
 * @sa [dc:created](http://purl.org/dc/terms/created).
 *
 * @date Last reviewed 2025-10-19
 */
class DcCreated extends AbstractDcStmt
{
    use DateTimeStmtTrait;

    public const PROP_LOCAL_NAME = 'created';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const IS_ONCE_ONLY = true;
}

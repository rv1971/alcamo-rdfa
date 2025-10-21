<?php

namespace alcamo\rdfa;

/**
 * @brief dc:rights RDFa statement
 *
 * @sa [dc:rights](http://purl.org/dc/terms/rights).
 *
 * @date Last reviewed 2025-10-19
 */
class DcRights extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'rights';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

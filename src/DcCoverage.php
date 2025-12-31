<?php

namespace alcamo\rdfa;

/**
 * @brief dc:coverage RDFa statement
 *
 * @sa [dc:coverage](http://purl.org/dc/terms/coverage).
 *
 * @date Last reviewed 2025-10-19
 */
class DcCoverage extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'coverage';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

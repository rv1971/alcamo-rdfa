<?php

namespace alcamo\rdfa;

/**
 * @brief dc:coverage RDFa statement
 *
 * @sa [dc:coverage](http://purl.org/dc/terms/coverage).
 *
 * @date Last reviewed 2025-10-15
 */
class DcCoverage extends AbstractStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'coverage';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;
}

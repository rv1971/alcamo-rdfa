<?php

namespace alcamo\rdfa;

/**
 * @brief dc:date RDFa statement
 *
 * @sa [dc:date](http://purl.org/dc/terms/date).
 *
 * @date Last reviewed 2025-10-16
 */
class DcDate extends AbstractDateTimeStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'date';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

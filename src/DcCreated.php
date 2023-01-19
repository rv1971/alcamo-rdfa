<?php

namespace alcamo\rdfa;

/**
 * @brief dc:created RDFa statement
 *
 * @sa [dc:created](http://purl.org/dc/terms/created).
 */
class DcCreated extends AbstractDateTimeStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'created';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;
}

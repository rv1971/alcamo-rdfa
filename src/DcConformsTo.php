<?php

namespace alcamo\rdfa;

/**
 * @brief dc:conformsTo RDFa statement
 *
 * @sa [dc:conformsTo](http://purl.org/dc/terms/conformsTo).
 */
class DcConformsTo extends AbstractNodeStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'conformsTo';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = false;
}

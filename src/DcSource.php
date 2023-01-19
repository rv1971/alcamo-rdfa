<?php

namespace alcamo\rdfa;

/**
 * @brief dc:source RDFa statement
 *
 * @sa [dc:source](http://purl.org/dc/terms/source).
 */
class DcSource extends AbstractNodeStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'source';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:creator RDFa statement
 *
 * @sa [dc:creator](http://purl.org/dc/terms/creator)
 */
class DcCreator extends AbstractStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'creator';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = false;
}

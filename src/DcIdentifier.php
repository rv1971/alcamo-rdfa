<?php

namespace alcamo\rdfa;

/**
 * @brief dc:identifier RDFa statement
 *
 * @sa [dc:identifier](http://purl.org/dc/terms/identifier).
 */
class DcIdentifier extends AbstractStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'identifier';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;
}

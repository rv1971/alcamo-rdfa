<?php

namespace alcamo\rdfa;

/**
 * @brief dc:alternative RDFa statement
 *
 * @sa [dc:alternative](http://purl.org/dc/terms/alternative).
 */
class DcAlternative extends AbstractStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'alternative';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

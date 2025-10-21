<?php

namespace alcamo\rdfa;

/**
 * @brief dc:alternative RDFa statement
 *
 * @sa [dc:alternative](http://purl.org/dc/terms/alternative).
 *
 * @date Last reviewed 2025-10-19
 */
class DcAlternative extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'alternative';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

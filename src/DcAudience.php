<?php

namespace alcamo\rdfa;

/**
 * @brief dc:audience RDFa statement
 *
 * @sa [dc:audience](http://purl.org/dc/terms/audience).
 *
 * @date Last reviewed 2025-10-19
 */
class DcAudience extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'audience';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

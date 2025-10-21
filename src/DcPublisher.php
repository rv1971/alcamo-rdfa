<?php

namespace alcamo\rdfa;

/**
 * @brief dc:publisher RDFa statement
 *
 * @sa [dc:publisher](http://purl.org/dc/terms/publisher).
 *
 * @date Last reviewed 2025-10-19
 */
class DcPublisher extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'publisher';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

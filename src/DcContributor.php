<?php

namespace alcamo\rdfa;

/**
 * @brief dc:contributor RDFa statement
 *
 * @sa [dc:contributor](http://purl.org/dc/terms/contributor)
 *
 * @date Last reviewed 2025-10-19
 */
class DcContributor extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'contributor';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

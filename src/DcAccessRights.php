<?php

namespace alcamo\rdfa;

/**
 * @brief dc:accessRights RDFa statement
 *
 * @sa [dc:accessRights](http://purl.org/dc/terms/accessRights).
 *
 * @date Last reviewed 2025-10-19
 */
class DcAccessRights extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'accessRights';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:abstract RDFa statement
 *
 * @sa [dc:abstract](http://purl.org/dc/terms/abstract).
 *
 * @date Last reviewed 2025-10-19
 */
class DcAbstract extends AbstractDcStmt
{
    public const PROP_LOCAL_NAME = 'abstract';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

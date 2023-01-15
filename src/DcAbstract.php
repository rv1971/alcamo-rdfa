<?php

namespace alcamo\rdfa;

/**
 * @brief dc:abstract RDFa statement
 *
 * @sa [dc:abstract](http://purl.org/dc/terms/abstract).
 */
class DcAbstract extends AbstractLiteralStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'abstract';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

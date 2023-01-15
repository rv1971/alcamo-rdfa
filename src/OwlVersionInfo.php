<?php

namespace alcamo\rdfa;

/**
 * @brief owl:versionInfo RDFa statement
 *
 * @sa [owl:versionInfo](https://www.w3.org/TR/owl-ref/#versionInfo-def).
 */
class OwlVersionInfo extends AbstractLiteralStmt
{
    public const PROP_NS_NAME = self::OWL_NS;

    public const PROP_NS_PREFIX = 'owl';

    public const PROP_LOCAL_NAME = 'versionInfo';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

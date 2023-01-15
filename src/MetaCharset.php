<?php

namespace alcamo\rdfa;

/**
 * @brief charset RDFa statement
 *
 * @sa [\<meta> charset attribute](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta#attr-charset)
 */
class MetaCharset extends AbstractLiteralStmt
{
    public const PROP_NS_NAME = self::META_NS;

    public const PROP_NS_PREFIX = 'meta';

    public const PROP_LOCAL_NAME = 'charset';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

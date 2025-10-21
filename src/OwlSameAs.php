<?php

namespace alcamo\rdfa;

/**
 * @brief owl:sameAs RDFa statement
 *
 * @sa [owl:sameAs](https://www.w3.org/TR/owl-ref/#sameAs-def).
 *
 * @date Last reviewed 2025-10-19
 */
class OwlSameAs extends AbstractOwlStmt
{
    use NodeStmtTrait;

    public const PROP_LOCAL_NAME = 'sameAs';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const IS_ONCE_ONLY = true;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief owl:versionInfo RDFa statement
 *
 * @sa [owl:versionInfo](https://www.w3.org/TR/owl-ref/#versionInfo-def).
 *
 * @date Last reviewed 2025-10-19
 */
class OwlVersionInfo extends AbstractOwlStmt
{
    use FixedLiteralTypeStmtTrait;

    public const PROP_LOCAL_NAME = 'versionInfo';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    /// Objects are language-agnostic
    public const LITERAL_CLASS = StringLiteral::class;
}

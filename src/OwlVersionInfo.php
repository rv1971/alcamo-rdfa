<?php

namespace alcamo\rdfa;

/**
 * @brief owl:versionInfo RDFa statement
 *
 * @sa [owl:versionInfo](https://www.w3.org/TR/owl-ref/#versionInfo-def).
 */
class OwlVersionInfo extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::OWL_NS . 'versionInfo';

    public const CANONICAL_PROPERTY_CURIE = 'owl:versionInfo';
}

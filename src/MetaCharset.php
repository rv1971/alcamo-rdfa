<?php

namespace alcamo\rdfa;

/**
 * @brief charset RDFa statement
 *
 * @sa [\<meta> charset attribute](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta#attr-charset)
 */
class MetaCharset extends AbstractLiteralObjectStmt
{
    public const PROPERTY_URI = self::META_NS . 'charset';

    public const CANONICAL_PROPERTY_CURIE = 'meta:charset';
}

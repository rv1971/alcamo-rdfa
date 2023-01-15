<?php

namespace alcamo\rdfa;

/**
 * @brief rel:up RDFa statement
 *
 * Indicates that the page is part of a hierarchical structure and that the
 * hyperlink leads to the higher level resource of that structure. Since in
 * HTML4 this has been removed from the HTML standard, there seems to be no
 * widely known property URI with this meaning.
 *
 * @sa [rel="up"](https://microformats.org/wiki/rel-up).
 *
 * @sa [Link types](https://developer.mozilla.org/en-US/docs/Web/HTML/Link_types)
 */
class RelUp extends AbstractRelStmt
{
    public const PROP_LOCAL_NAME = 'up';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE = self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

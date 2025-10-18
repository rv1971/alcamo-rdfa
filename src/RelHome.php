<?php

namespace alcamo\rdfa;

/**
 * @brief rel:home RDFa statement
 *
 * Used to express that the object is the site's home page. Since in HTML4 this
 * has been removed from the HTML standard, there seems to be no widely known
 * property URI with this meaning.
 *
 * @sa [rel="home"](https://microformats.org/wiki/rel-home).
 *
 * @date Last reviewed 2025-10-18
 */
class RelHome extends AbstractNodeStmt
{
    public const PROP_NS_NAME = self::REL_NS;

    public const PROP_NS_PREFIX = 'rel';

    public const PROP_LOCAL_NAME = 'home';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;
}

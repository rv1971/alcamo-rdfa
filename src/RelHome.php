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
 */
class RelHome extends AbstractRelStmt
{
    public const PROPERTY_URI = self::REL_NS . 'home';

    public const CANONICAL_PROPERTY_CURIE = 'rel:home';
}

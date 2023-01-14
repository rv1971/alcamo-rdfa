<?php

namespace alcamo\rdfa;

/**
 * @brief rel:contents RDFa statement
 *
 * Refers to a document serving as a table of contents. Since in
 * HTML5 this has been removed from the HTML standard, there seems to be no
 * widely known property URI with this meaning.
 *
 * @sa [Link types](https://www.w3.org/TR/html4/types.html#h-6.12)
 */
class RelContents extends AbstractRelStmt
{
    public const PROPERTY_URI = self::REL_NS . 'contents';

    public const PROPERTY_CURIE = 'rel:contents';
}

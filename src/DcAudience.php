<?php

namespace alcamo\rdfa;

/**
 * @brief dc:audience RDFa statement
 *
 * @sa [dc:audience](http://purl.org/dc/terms/audience).
 *
 * @date Last reviewed 2021-06-21
 */
class DcAudience extends AbstractStmt
{
    use LiteralContentOrLinkTrait;

    public const PROPERTY_CURIE = 'dc:audience';
    public const RESOURCE_LABEL = 'Audience';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief dc:publisher RDFa statement
 *
 * @sa [dc:publisher](http://purl.org/dc/terms/publisher).
 *
 * @date Last reviewed 2021-06-21
 */
class DcPublisher extends AbstractStmt
{
    use LiteralContentOrLinkTrait;

    public const PROPERTY_CURIE = 'dc:publisher';
    public const RESOURCE_LABEL = 'Publisher';
}

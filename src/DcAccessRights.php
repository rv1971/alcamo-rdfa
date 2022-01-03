<?php

namespace alcamo\rdfa;

/**
 * @brief dc:accessRights RDFa statement
 *
 * @sa [dc:accessRights](http://purl.org/dc/terms/accessRights).
 */
class DcAccessRights extends AbstractStmt
{
    use LiteralContentOrLinkTrait;

    public const PROPERTY_CURIE = 'dc:accessRights';
    public const RESOURCE_LABEL = 'Access rights';
}

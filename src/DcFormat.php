<?php

namespace alcamo\rdfa;

use alcamo\iana\MediaType;

/**
 * @brief dc:format RDFa statement
 *
 * @sa [dc:format](http://purl.org/dc/terms/format).
 */
class DcFormat extends AbstractStmt
{
    public const PROPERTY_URI = self::DC_NS . 'format';

    public const CANONICAL_PROPERTY_CURIE = 'dc:format';

    public const OBJECT_CLASS = MediaType::class;

    public function __construct(MediaType $mediaType)
    {
        parent::__construct($mediaType);
    }
}

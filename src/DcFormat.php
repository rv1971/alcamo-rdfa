<?php

namespace alcamo\rdfa;

/**
 * @brief dc:format RDFa statement
 *
 * @sa [dc:format](http://purl.org/dc/terms/format).
 *
 * @date Last reviewed 2025-10-16
 */
class DcFormat extends AbstractStmt
{
    public const PROP_NS_NAME = self::DC_NS;

    public const PROP_NS_PREFIX = 'dc';

    public const PROP_LOCAL_NAME = 'format';

    public const PROP_URI = self::PROP_NS_NAME . self::PROP_LOCAL_NAME;

    public const PROP_CURIE =
        self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME;

    public const UNIQUE = true;

    public function __construct($mediaType)
    {
        parent::__construct(
            $mediaType instanceof MediaType
            ? $mediaType
            : MediaType::newFromString($mediaType)
        );
    }
}

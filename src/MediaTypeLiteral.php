<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa media type literal
 *
 * @date Last reviewed 2026-02-12
 */
class MediaTypeLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XH_NS . 'ContentType';

    /*
     * @param $value MediaType|string MediaType or media type string.
     *
     * @param $datatypeUri Datatype IRI. [Default `xh:ContentType`]
     */
    public function __construct($value, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof MediaType
                ? $value
                : MediaType::newFromString($value),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

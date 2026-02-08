<?php

namespace alcamo\rdfa;

use alcamo\time\Duration;

/**
 * @brief RDFa duration literal
 *
 * @date Last reviewed 2026-02-05
 */
class DurationLiteral extends Literal
{
    public const DATATYPE_URI = self::XSD_NS_NAME . 'duration';

    /**
     * @param $value Duration|string Duration or duration string.
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:duration`]
     */
    public function __construct($value, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof Duration ? $value : new Duration($value),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

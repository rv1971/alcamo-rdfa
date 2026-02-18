<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian day literal
 *
 * @date Last reviewed 2026-02-18
 */
class GDayLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'gDay';

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'd';

    /**
     * @param $value DateTime|string|int DateTime or day string or number.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof \DateTime ? $value : new \DateTime(
                (new \DateTime())->format("Y-m-$value")
            ),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

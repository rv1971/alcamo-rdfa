<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian month/day literal
 *
 * @date Last reviewed 2026-02-18
 */
class GMonthDayLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'gMonthDay';

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'm-d';

    /**
     * @param $value DateTime|string DateTime or month-day string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof \DateTime
                ? $value
                : new \DateTime((new \DateTime())->format("Y-$value")),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

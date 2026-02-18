<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian month literal
 *
 * @date Last reviewed 2026-02-18
 */
class GMonthLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'gMonth';

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'm';

    /**
     * @param $value DateTime|string|int DateTime or month string or number.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        $now = new \DateTime();

        parent::__construct(
            $value instanceof \DateTime ? $value : new \DateTime(
                (new \DateTime())->format("Y-$value-d")
            ),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

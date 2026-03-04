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

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'm-d';

    /**
     * @param $value DateTime|string DateTime or month-day string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        switch (true) {
            case $value instanceof \DateTime:
                $dateTime = $value;
                break;

            case !isset($value) || $value === '':
                $dateTime = new \DateTime();
                break;

            default:
                /* Simply try parsing $value with timezone; if this fails, try
                 * without. */
                $dateTime = \DateTime::createFromFormat('m-de', $value);

                if ($dateTime === false) {
                    $dateTime = \DateTime::createFromFormat('m-d', $value);
                }
        }

        parent::__construct($dateTime, $datatypeUri);
    }
}

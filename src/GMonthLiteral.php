<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian month literal
 *
 * @date Last reviewed 2026-02-18
 */
class GMonthLiteral extends DateTimeLiteral implements
    ConvertibleToIntInterface
{
    public const DATATYPE_URI = self::XSD_NS . 'gMonth';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'm';

    /**
     * @param $value DateTime|string|int DateTime or month string or number.
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

            case is_int($value):
                $dateTime = \DateTime::createFromFormat('m', $value);
                break;

            default:
                $dateTime = \DateTime::createFromFormat(
                    ctype_digit($value) ? 'm' : 'me',
                    $value
                );
        }

        parent::__construct($dateTime, $datatypeUri);
    }

    public function toInt(): int
    {
        return $this->value_->format('m');
    }
}

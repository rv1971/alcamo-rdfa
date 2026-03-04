<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian day literal
 *
 * @date Last reviewed 2026-02-18
 */
class GDayLiteral extends DateTimeLiteral implements ConvertibleToIntInterface
{
    public const DATATYPE_URI = self::XSD_NS . 'gDay';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'd';

    /**
     * @param $value DateTime|string|int DateTime or day string or number.
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
                $dateTime = \DateTime::createFromFormat('d', $value);
                break;

            default:
                $dateTime = \DateTime::createFromFormat(
                    ctype_digit($value) ? 'd' : 'de',
                    $value
                );
        }

        parent::__construct($dateTime, $datatypeUri);
    }

    public function toInt(): int
    {
        return $this->value_->format('d');
    }
}

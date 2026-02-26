<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian year literal
 *
 * @date Last reviewed 2026-02-18
 */
class GYearLiteral extends DateTimeLiteral implements ConvertibleToIntInterface
{
    public const DATATYPE_URI = self::XSD_NS . 'gYear';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'Y';


    /**
     * @param $value DateTime|int|string DateTime or year integer or string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        switch (true) {
            case $value instanceof \DateTime:
                break;

            case !isset($value) || $value === '':
                $value = new \DateTime();
                break;

            case is_int($value):
                $value = new \DateTime(
                    ($value < 0 ? '-' : '')
                        . str_pad(abs($value), 4, '0', STR_PAD_LEFT) . '-01-01'
                );
                break;

            default:
                $value = trim($value);

                if ($value[0] == '-') {
                    $sign = '-';
                    $value = substr($value, 1);
                } else {
                    $sign = '';
                }

                $yearLength = strspn($value, '0123456789');

                $value = new \DateTime(
                    $sign
                        . str_pad(
                            substr($value, 0, $yearLength),
                            4,
                            '0',
                            STR_PAD_LEFT
                        )
                        . '-01-01' . substr($value, $yearLength)
                );
        }

        parent::__construct($value, $datatypeUri ?? static::DATATYPE_URI);
    }

    public function toInt(): int
    {
        return $this->value_->format('Y');
    }
}

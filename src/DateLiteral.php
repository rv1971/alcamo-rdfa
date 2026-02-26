<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa date literal
 *
 * @date Last reviewed 2026-02-05
 */
class DateLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'date';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'Y-m-d';
}

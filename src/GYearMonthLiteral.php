<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian year/month literal
 *
 * @date Last reviewed 2026-02-18
 */
class GYearMonthLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'gYearMonth';

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'Y-m';
}

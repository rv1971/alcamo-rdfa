<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa gregorian year literal
 *
 * @date Last reviewed 2026-02-18
 */
class GYearLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'gYear';

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'Y';
}

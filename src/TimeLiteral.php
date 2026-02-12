<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa time literal
 *
 * @date Last reviewed 2026-02-05
 */
class TimeLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'time';

    /// Format content as ISO 8601 string without timezone
    public const FORMAT = 'H:i:s';
}

<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa time literal
 *
 * @date Last reviewed 2026-02-05
 */
class TimeLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS_URI . 'time';

    /// Return content using as ISO 8601 string without timezone
    public function __toString(): string
    {
        return $this->value_->format('H:i:s');
    }
}

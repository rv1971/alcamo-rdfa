<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa date literal
 *
 * @date Last reviewed 2026-02-05
 */
class DateLiteral extends DateTimeLiteral
{
    public const DATATYPE_URI = self::XSD_NS_NAME . 'date';

    /// Return content using as ISO 8601 string without timezone
    public function __toString(): string
    {
        return $this->value_->format('Y-m-d');
    }
}

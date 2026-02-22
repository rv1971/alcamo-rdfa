<?php

namespace alcamo\rdfa;

use alcamo\uri\Uri;

/**
 * @brief Class that contains an XSD
 *
 * @date Last reviewed 2026-02-22
 */
trait HavingInlineXsdTrait
{
    /// XSD text contained in alcamo::rdfa::PositiveGYearLiteral::DATATYPE_URI
    public static function createXsdText(): string
    {
        /* The character at position 0 is the comma. */
        return
            rawurldecode(substr((new Uri(static::DATATYPE_URI))->getPath(), 1));
    }
}

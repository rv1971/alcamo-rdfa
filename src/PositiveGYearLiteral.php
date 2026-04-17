<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;

/**
 * @brief RDFa positive gregorian year literal
 *
 * @date Last reviewed 2026-02-22
 */
class PositiveGYearLiteral extends GYearLiteral
{
    use CustomTypeLiteralTrait;

    /// Local name of the udnerlying datatype
    public const DATATYPE_LOCAL_NAME = 'PositiveGYear';

    /// Extended name of the underlying datatype
    public const DATATYPE_XNAME =
        self::ALCAMO_BASE_NS . ' ' . self::DATATYPE_LOCAL_NAME;

    /// Absolute path of the XSD file containing the type
    public const XSD_FILENAME = __DIR__ . DIRECTORY_SEPARATOR
        . '..' . DIRECTORY_SEPARATOR
        . 'xsd' . DIRECTORY_SEPARATOR . 'alcamo.rdfa.xsd';

    protected function validateValue(): void
    {
        /** @throw alcamo::exception::OutOfRange if $value is a negative
         *  year. */
        OutOfRange::throwIfNegative($this->format('Y'));
    }
}

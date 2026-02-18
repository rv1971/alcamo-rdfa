<?php

namespace alcamo\rdfa;

use alcamo\binary_data\BinaryString;

/**
 * @brief RDFa hexBinary literal
 *
 * @date Last reviewed 2026-02-18
 */
class HexBinaryLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'hexBinary';

    /**
     * @param $value BinaryString|string BinaryString or hex string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof BinaryString
                ? $value
                : BinaryString::newFromHex($value),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

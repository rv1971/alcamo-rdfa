<?php

namespace alcamo\rdfa;

/**
 * @brief RDF double floating point number literal
 *
 * @date Last reviewed 2026-02-26
 */
class DoubleLiteral extends FloatLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'double';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;
}

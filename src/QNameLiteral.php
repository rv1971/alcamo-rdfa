<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa QName literal
 *
 * @date Last reviewed 2026-02-26
 */
class QNameLiteral extends StringLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'QName';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;
}

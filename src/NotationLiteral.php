<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa notation literal
 *
 * @date Last reviewed 2026-02-26
 */
class NotationLiteral extends QNameLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'NOTATION';

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;
}

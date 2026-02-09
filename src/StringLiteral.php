<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa string literal
 *
 * @date Last reviewed 2026-02-09
 */
class StringLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS_NAME . 'string';
}

<?php

namespace alcamo\rdfa;

use alcamo\rdf_literal\NonNegativeIntegerLiteral;

/**
 * @brief Resolution RDFa statement
 *
 * @date Last reviewed 2026-10-20
 */
abstract class AbstractExifResolution extends AbstractExifStmt
{
    use FixedLiteralTypeStmtTrait;

    public const LITERAL_CLASS = NonNegativeIntegerLiteral::class;
}

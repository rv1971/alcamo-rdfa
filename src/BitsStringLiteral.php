<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;

/**
 * @brief RDFa bits string literal
 *
 * A bits string is a string made of the digits 0 and 1.
 *
 * @date Last reviewed 2026-04-17
 */
class BitsStringLiteral extends DigitsStringLiteral
{
    public const DATATYPE_LOCAL_NAME = 'BitsString';

    public const DATATYPE_XNAME =
        self::ALCAMO_BASE_NS . ' ' . self::DATATYPE_LOCAL_NAME;

    protected function validateValue(): void
    {
        if (ltrim($this->value_, '01') != '') {
            /** @throw alcamo::exception::SyntaxError if $this->value_ contains
             *  characters other than 0 and 1. */
            throw (
                new SyntaxError(
                    '{value} contains characters other than 0 and 1'
                )
            )
                ->setMessageContext([ 'value' => $this->value_ ]);
        }
    }
}

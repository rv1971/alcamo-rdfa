<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;

/**
 * @brief RDFa digits string literal
 *
 * A digits string is a string made of digits. It differs from a nonnegative
 * integer by the fact that it can be of arbitrary length and that leading
 * zeros make a difference, i.e. the numeric string `007` is different from
 * `7`.
 *
 * @date Last reviewed 2026-04-17
 */
class DigitsStringLiteral extends FourBitStringLiteral
{
    public const DATATYPE_LOCAL_NAME = 'DigitsString';

    public const DATATYPE_XNAME =
        self::ALCAMO_BASE_NS . ' ' . self::DATATYPE_LOCAL_NAME;

    protected function validateValue(): void
    {
        if (!ctype_digit($this->value_)) {
            /** @throw alcamo::exception::SyntaxError if $this->value_
             *  contains non-digit characters. */
            throw (new SyntaxError('{value} contains non-digits'))
                ->setMessageContext([ 'value' => $this->value_ ]);
        }
    }
}

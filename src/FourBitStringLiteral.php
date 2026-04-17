<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;

/**
 * @brief RDFa four-bit string literal
 *
 * A four-bit string literal is a string made of digits and the six ASCII
 * characters following `9`, namely `:;<=>?`.
 *
 * @date Last reviewed 2026-04-17
 */
class FourBitStringLiteral extends StringLiteral
{
    use CustomTypeLiteralTrait;

    /// Local name of the underlying datatype
    public const DATATYPE_LOCAL_NAME = 'FourBitString';

    /// Extended name of the underlying datatype
    public const DATATYPE_XNAME =
        self::ALCAMO_BASE_NS . ' ' . self::DATATYPE_LOCAL_NAME;

    /// Absolute path of the XSD file containing the type
    public const XSD_FILENAME = __DIR__ . DIRECTORY_SEPARATOR
        . '..' . DIRECTORY_SEPARATOR
        . 'xsd' . DIRECTORY_SEPARATOR . 'alcamo.rdfa.xsd';

    /// Create from equivalent hexadecimal string
    public static function newFromHex(string $value, $datatypeUri = null): self
    {
        return new static(
            strtr($value, 'ABCDEFabcdef', ':;<=>?:;<=>?'),
            $datatypeUri
        );
    }

    /// Equivalent hexadecimal string
    public function toHex(): string
    {
        return strtr($this->value_, ':;<=>?', 'ABCDEF');
    }

    protected function validateValue(): void
    {
        if (!ctype_xdigit(strtr($this->value_, ':;<=>?', 'ABCDEF'))) {
            /** @throw alcamo::exception::SyntaxError if $this->value_
             *  contains non-four-bit characters. */
            throw (new SyntaxError('{value} contains non-four-bit characters'))
                ->setMessageContext([ 'value' => $this->value_ ]);
        }
    }
}

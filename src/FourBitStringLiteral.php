<?php

namespace alcamo\rdfa;

use alcamo\exception\SyntaxError;

/**
 * @brief RDFa four-bit string literal
 *
 * A four-bit string literal is a string made of digits and the six ASCII
 * characters following `9`, namely `:;<=>?`.
 *
 * @date Last reviewed 2026-02-22
 */
class FourBitStringLiteral extends StringLiteral
{
    use HavingInlineXsdTrait;

    /**
     * `data:` URI representation of the `FourBitString` fragment of
     *
     *     <?xml version="1.0"?>
     *     <schema
     *         xmlns="http://www.w3.org/2001/XMLSchema"
     *         targetNamespace="tag:rv1971@web.de,2021:alcamo:ns:base#">
     *       <simpleType
     *           name="FourBitString"
     *           xml:id="FourBitString">
     *         <restriction base="string">
     *           <pattern value="[0-?]*"/>
     *         </restriction>
     *       </simpleType>
     *     </schema>
     */
    public const DATATYPE_URI = "data:,%3C%3Fxml%20version='1.0'%3F%3E"
        . "%3Cschema%20xmlns='http://www.w3.org/2001/XMLSchema'%20"
        . "targetNamespace='tag:rv1971%40web.de,2021:alcamo:ns:base%23'%3E"
        . "%3CsimpleType%20name='FourBitString'%20xml:id='FourBitString'%3E"
        . "%3Crestriction%20base='string'%3E%3Cpattern%20"
        . "value='%5B0-%3F%5D*'/%3E"
        . "%3C/restriction%3E%3C/simpleType%3E%3C/schema%3E#FourBitString";

    /// Create from equivalent hexadecimal string
    public static function newFromHex(string $value): self
    {
        return new static(strtr($value, 'ABCDEFabcdef', ':;<=>?:;<=>?'));
    }

    /**
     * @param $value stringable. Any leading and trailing whitespace is removed.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:string`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        $value = trim($value);

        if (!ctype_xdigit(strtr($value, ':;<=>?', 'ABCDEF'))) {
            /** @throw alcamo::exception::SyntaxError if $value contains
             *  non-four-bit characters. */
            throw (new SyntaxError('{value} contains non-four-bit characters'))
                ->setMessageContext([ 'value' => $value ]);
        }

        parent::__construct($value, $datatypeUri ?? static::DATATYPE_URI);
    }

    /// Equivalent hexadecimal string
    public function toHex(): string
    {
        return strtr($this->value_, ':;<=>?', 'ABCDEF');
    }
}

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
 * @date Last reviewed 2026-02-22
 */
class DigitsStringLiteral extends StringLiteral
{
    use HavingInlineXsdTrait;

    /**
     * `data:` URI representation of the `DigitsString` fragment of
     *
     *     <?xml version="1.0"?>
     *     <schema
     *         xmlns="http://www.w3.org/2001/XMLSchema"
     *         targetNamespace="tag:rv1971@web.de,2021:alcamo:ns:base#">
     *       <simpleType
     *           name="DigitsString"
     *           xml:id="DigitsString">
     *         <restriction base="string">
     *           <pattern value="\d*"/>
     *         </restriction>
     *       </simpleType>
     *     </schema>
     */
    public const DATATYPE_URI = "data:,%3C%3Fxml%20version='1.0'%3F%3E"
        . "%3Cschema%20xmlns='http://www.w3.org/2001/XMLSchema'%20"
        . "targetNamespace='tag:rv1971%40web.de,2021:alcamo:ns:base%23'%3E"
        . "%3CsimpleType%20name='DigitsString'%20xml:id='DigitsString'%3E"
        . "%3Crestriction%20base='string'%3E%3Cpattern%20value='%5Cd*'/%3E"
        . "%3C/restriction%3E%3C/simpleType%3E%3C/schema%3E#DigitsString";

    /**
     * @param $value stringable. Any leading and trailing whitespace is removed.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:string`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        $value = trim($value);

        if (!ctype_digit($value)) {
            /** @throw alcamo::exception::SyntaxError if $value contains
             *  non-digit characters. */
            throw (new SyntaxError('{value} contains non-digits'))
                ->setMessageContext([ 'value' => $value ]);
        }

        parent::__construct($value, $datatypeUri ?? static::DATATYPE_URI);
    }
}

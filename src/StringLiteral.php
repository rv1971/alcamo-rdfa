<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa string literal
 *
 * @date Last reviewed 2026-02-09
 */
class StringLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'string';

    /**
     * @param $value stringable.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:string`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct(
            (string)$value,
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

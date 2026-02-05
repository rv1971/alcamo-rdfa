<?php

namespace alcamo\rdfa;

/**
 * @brief RDF integer literal
 *
 * @date Last reviewed 2026-02-05
 */
class IntegerLiteral extends Literal
{
    public const DATATYPE_URI = self::XSD_NS_URI . 'integer';

    /**
     * @param $value int|string Integer or integer string.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:integer`]
     */
    public function __construct($value, $datatypeUri = null)
    {
        parent::__construct((int)$value, $datatypeUri ?? static::DATATYPE_URI);
    }
}

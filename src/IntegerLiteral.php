<?php

namespace alcamo\rdfa;

/**
 * @brief RDF integer literal
 *
 * @date Last reviewed 2026-02-05
 */
class IntegerLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'integer';

    /**
     * @param $value int|string Integer or integer string.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:integer`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct((int)$value, $datatypeUri ?? static::DATATYPE_URI);
    }

    public function toInt(): int
    {
        return $this->value_;
    }
}

<?php

namespace alcamo\rdfa;

/**
 * @brief RDF floating point number literal
 *
 * @date Last reviewed 2026-02-05
 */
class FloatLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'double';

    /**
     * @param $value double|float|string Floating point number or string.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:double`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct(
            (float)$value,
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;

/**
 * @brief RDF nonnegative integer literal
 *
 * @date Last reviewed 2026-02-22
 */
class NonNegativeIntegerLiteral extends IntegerLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'nonNegativeInteger';

    /**
     * @param $value int|string nonnegative Integer or integer string.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:nonNegativeInteger`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        /** @throw alcamo::exception::OutOfRange if $value is negative. */
        OutOfRange::throwIfNegative($value);

        parent::__construct((int)$value, $datatypeUri);
    }
}

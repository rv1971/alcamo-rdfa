<?php

namespace alcamo\rdfa;

use alcamo\exception\OutOfRange;

/**
 * @brief RDF nonnegative integer literal
 *
 * @date Last reviewed 2026-02-22
 */
class NonNegativeIntegerLiteral extends AbstractLiteral implements
    ConvertibleToIntInterface
{
    public const DATATYPE_URI = self::XSD_NS . 'nonNegativeInteger';

    /**
     * @param $value int|string nonnegative Integer or integer string.
     *
     * @param $datatypeUri Datatype IRI. [default `xsd:nonNegativeInteger`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        OutOfRange::throwIfNegative($value);

        parent::__construct((int)$value, $datatypeUri ?? static::DATATYPE_URI);
    }

    public function toInt(): int
    {
        return $this->value_;
    }
}

<?php

namespace alcamo\rdfa;

/**
 * @brief RDF boolean literal
 *
 * @date Last reviewed 2026-02-05
 */
class BooleanLiteral extends AbstractLiteral implements
    ConvertibleToIntInterface
{
    public const DATATYPE_URI = self::XSD_NS . 'boolean';

    /**
     * @param @param $value bool|string Boolean or boolean string.
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:boolean`]
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        parent::__construct(
            is_bool($value)
                ? $value
                : ((string)$value === 'true' || (string)$value === '1'),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }

    /// Return `true` or `false`
    public function __toString(): string
    {
        return $this->value_ ? 'true' : 'false';
    }

    public function toInt(): int
    {
        return $this->value_;
    }
}

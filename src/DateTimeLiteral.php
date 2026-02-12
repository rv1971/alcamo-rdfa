<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa datetime literal
 *
 * @date Last reviewed 2026-02-05
 */
class DateTimeLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'dateTime';

    /// Format used in __toString()
    public const FORMAT = 'c';

    /**
     * @param $value DateTime|string DateTime or datetime string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof \DateTime ? $value : new \DateTime($value),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }

    /// Return content using as ISO 8601 string with timezone
    public function __toString(): string
    {
        return $this->value_->format(static::FORMAT);
    }
}

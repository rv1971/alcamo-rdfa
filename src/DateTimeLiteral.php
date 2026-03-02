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

    public const PRIMITIVE_DATATYPE_URI = self::DATATYPE_URI;

    /// Format used in __toString()
    public const FORMAT = 'c';

    /**
     * @param $value DateTime|string DateTime or datetime string.
     *
     * @param $datatypeUri Datatype IRI.
     */
    public function __construct($value = null, $datatypeUri = null)
    {
        /* PHP does not interpret negative dates according to
         * https://www.w3.org/TR/xmlschema-2/#date */
        if (!($value instanceof \Datetime)) {
            $value = ltrim($value);

            if (isset($value[0]) && $value[0] == '-') {
                $value = new \DateTime(ltrim($value, " \n\r\t\v\x00-"));
                $value->setDate(
                    -$value->format('Y'),
                    $value->format('m'),
                    $value->format('d')
                );
            } else {
                $value = new \DateTime($value);
            }
        }

        parent::__construct($value, $datatypeUri);
    }

    /// Return content using as ISO 8601 string with timezone
    public function __toString(): string
    {
        return $this->value_->format(static::FORMAT);
    }

    public function format(string $format): string
    {
        return $this->value_->format($format);
    }

    /**
     * @copydoc alcamo::rdfa::LiteralInterface::equals()
     *
     * The DateTime values in this literal class are considered equal if the
     * relavant components, including the timezone, are equal.
     */
    public function equals(LiteralInterface $literal): bool
    {
        return $literal::PRIMITIVE_DATATYPE_URI == $this::PRIMITIVE_DATATYPE_URI
            && $literal->format(static::FORMAT . 'O')
            == $this->value_->format(static::FORMAT . 'O');
    }
}

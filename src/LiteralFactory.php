<?php

namespace alcamo\rdfa;

/**
 * @brief RDF literal factory
 *
 * @date Last reviewed 2026-02-05
 */
class LiteralFactory implements LiteralFactoryInterface
{
    /// Mapping of RDF data type IRIs to classes
    public const DATATYPE_URI_TO_CLASS = [
        BooleanLiteral::DATATYPE_URI    => BooleanLiteral::class,
        DateLiteral::DATATYPE_URI       => DateLiteral::class,
        DateTimeLiteral::DATATYPE_URI   => DateTimeLiteral::class,
        DurationLiteral::DATATYPE_URI   => DurationLiteral::class,
        FloatLiteral::DATATYPE_URI      => FloatLiteral::class,
        IntegerLiteral::DATATYPE_URI    => IntegerLiteral::class,
        LanguageLiteral::DATATYPE_URI   => LanguageLiteral::class,
        TimeLiteral::DATATYPE_URI       => TimeLiteral::class,

        self::XSD_NS_URI . 'byte'               => IntegerLiteral::class,
        self::XSD_NS_URI . 'int'                => IntegerLiteral::class,
        self::XSD_NS_URI . 'long'               => IntegerLiteral::class,
        self::XSD_NS_URI . 'negativeInteger'    => IntegerLiteral::class,
        self::XSD_NS_URI . 'nonNegativeInteger' => IntegerLiteral::class,
        self::XSD_NS_URI . 'nonPositiveInteger' => IntegerLiteral::class,
        self::XSD_NS_URI . 'positiveInteger'    => IntegerLiteral::class,
        self::XSD_NS_URI . 'short'              => IntegerLiteral::class,
        self::XSD_NS_URI . 'unsignedByte'       => IntegerLiteral::class,
        self::XSD_NS_URI . 'unsignedInt'        => IntegerLiteral::class,
        self::XSD_NS_URI . 'unsignedLong'       => IntegerLiteral::class,
        self::XSD_NS_URI . 'unsignedShort'      => IntegerLiteral::class,

        self::XSD_NS_URI . 'decimal'            => FloatLiteral::class,
        self::XSD_NS_URI . 'float'              => FloatLiteral::class
    ];

    public function create($value, $datatypeUri = null): LiteralInterface
    {
        switch (true) {
            case isset($datatypeUri)
                && isset(static::DATATYPE_URI_TO_CLASS[(string)$datatypeUri]):
                $class = static::DATATYPE_URI_TO_CLASS[(string)$datatypeUri];

                return new $class($value, $datatypeUri);

            case is_bool($value):
                return new BooleanLiteral($value, $datatypeUri);

            case is_float($value):
                return new FloatLiteral($value, $datatypeUri);

            case is_int($value):
                return new IntegerLiteral($value, $datatypeUri);

            case $value instanceof \DateTimeInterface:
                return new DateTimeLiteral($value, $datatypeUri);

            case $value instanceof \DateInterval:
                return new DurationLiteral($value, $datatypeUri);

            case $value instanceof Lang:
                return new LanguageLiteral($value, $datatypeUri);

            case $datatypeUri == LangStringLiteral::DATATYPE_URI:
                /* Here the second argument would be the language, not the
                 * data type. The third argument is redudant because known. */
                return new LangStringLiteral($value);

            default:
                return new Literal($value, $datatypeUri);
        }
    }

    public function convertValue($value, $datatypeUri)
    {
        if (isset(static::DATATYPE_URI_TO_CLASS[(string)$datatypeUri])) {
            $class = static::DATATYPE_URI_TO_CLASS[(string)$datatypeUri];

            return (new $class($value, $datatypeUri))->getValue();
        } else {
            return $value;
        }
    }
}

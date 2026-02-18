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
        Base64BinaryLiteral::DATATYPE_URI   => Base64BinaryLiteral::class,
        BooleanLiteral::DATATYPE_URI        => BooleanLiteral::class,
        DateLiteral::DATATYPE_URI           => DateLiteral::class,
        DateTimeLiteral::DATATYPE_URI       => DateTimeLiteral::class,
        DurationLiteral::DATATYPE_URI       => DurationLiteral::class,
        FloatLiteral::DATATYPE_URI          => FloatLiteral::class,
        GDayLiteral::DATATYPE_URI           => GDayLiteral::class,
        GMonthDayLiteral::DATATYPE_URI      => GMonthDayLiteral::class,
        GMonthLiteral::DATATYPE_URI         => GMonthLiteral::class,
        GYearLiteral::DATATYPE_URI          => GYearLiteral::class,
        GYearMonthLiteral::DATATYPE_URI     => GYearMonthLiteral::class,
        HexBinaryLiteral::DATATYPE_URI      => HexBinaryLiteral::class,
        IntegerLiteral::DATATYPE_URI        => IntegerLiteral::class,
        LanguageLiteral::DATATYPE_URI       => LanguageLiteral::class,
        MediaTypeLiteral::DATATYPE_URI      => MediaTypeLiteral::class,
        StringLiteral::DATATYPE_URI         => StringLiteral::class,
        TimeLiteral::DATATYPE_URI           => TimeLiteral::class,

        self::XSD_NS . 'byte'               => IntegerLiteral::class,
        self::XSD_NS . 'int'                => IntegerLiteral::class,
        self::XSD_NS . 'long'               => IntegerLiteral::class,
        self::XSD_NS . 'negativeInteger'    => IntegerLiteral::class,
        self::XSD_NS . 'nonNegativeInteger' => IntegerLiteral::class,
        self::XSD_NS . 'nonPositiveInteger' => IntegerLiteral::class,
        self::XSD_NS . 'positiveInteger'    => IntegerLiteral::class,
        self::XSD_NS . 'short'              => IntegerLiteral::class,
        self::XSD_NS . 'unsignedByte'       => IntegerLiteral::class,
        self::XSD_NS . 'unsignedInt'        => IntegerLiteral::class,
        self::XSD_NS . 'unsignedLong'       => IntegerLiteral::class,
        self::XSD_NS . 'unsignedShort'      => IntegerLiteral::class,

        self::XSD_NS . 'decimal'            => FloatLiteral::class,
        self::XSD_NS . 'float'              => FloatLiteral::class
    ];

    /**
     * @param $value stringable
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:langString`]
     *
     * @param $lang Lang object or language string. Considered only if a
     * LangStringLiteral is returned, i.e. if either the datatype is that of
     * language-tagged string or $lang is not `null` and the type to return
     * could not be deduced neither from the type of $value nor from
     * $datatypeUri.
     */
    public function create(
        $value,
        $datatypeUri = null,
        $lang = null
    ): LiteralInterface {
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
            case isset($lang):
                return new LangStringLiteral($value, $lang, $datatypeUri);

            default:
                return new StringLiteral($value, $datatypeUri);
        }
    }

    public function convertValue($value, $datatypeUri)
    {
        if ($value instanceof LiteralInterface) {
            $value = $value->getValue();
        }

        if (isset(static::DATATYPE_URI_TO_CLASS[(string)$datatypeUri])) {
            $class = static::DATATYPE_URI_TO_CLASS[(string)$datatypeUri];

            return (new $class($value, $datatypeUri))->getValue();
        } else {
            return (string)$value;
        }
    }
}

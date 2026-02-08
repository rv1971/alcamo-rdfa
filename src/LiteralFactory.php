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

        self::XSD_NS_NAME . 'byte'               => IntegerLiteral::class,
        self::XSD_NS_NAME . 'int'                => IntegerLiteral::class,
        self::XSD_NS_NAME . 'long'               => IntegerLiteral::class,
        self::XSD_NS_NAME . 'negativeInteger'    => IntegerLiteral::class,
        self::XSD_NS_NAME . 'nonNegativeInteger' => IntegerLiteral::class,
        self::XSD_NS_NAME . 'nonPositiveInteger' => IntegerLiteral::class,
        self::XSD_NS_NAME . 'positiveInteger'    => IntegerLiteral::class,
        self::XSD_NS_NAME . 'short'              => IntegerLiteral::class,
        self::XSD_NS_NAME . 'unsignedByte'       => IntegerLiteral::class,
        self::XSD_NS_NAME . 'unsignedInt'        => IntegerLiteral::class,
        self::XSD_NS_NAME . 'unsignedLong'       => IntegerLiteral::class,
        self::XSD_NS_NAME . 'unsignedShort'      => IntegerLiteral::class,

        self::XSD_NS_NAME . 'decimal'            => FloatLiteral::class,
        self::XSD_NS_NAME . 'float'              => FloatLiteral::class
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

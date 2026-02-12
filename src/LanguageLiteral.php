<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa language literal
 *
 * @date Last reviewed 2026-02-05
 */
class LanguageLiteral extends AbstractLiteral
{
    public const DATATYPE_URI = self::XSD_NS . 'language';

    /*
     * @param $value Lang|string Lang or language string.
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:language`]
     */
    public function __construct($value, $datatypeUri = null)
    {
        parent::__construct(
            $value instanceof Lang ? $value : Lang::newFromString($value),
            $datatypeUri ?? static::DATATYPE_URI
        );
    }
}

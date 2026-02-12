<?php

namespace alcamo\rdfa;

/**
 * @brief RDF literal factory
 *
 * @date Last reviewed 2026-02-05
 */
interface LiteralFactoryInterface
{
    public const RDF_NS = LiteralInterface::RDF_NS;

    public const XSD_NS = LiteralInterface::XSD_NS;

    /**
     * @param $value in any appropriate PHP type.
     *
     * @param $datatypeUri Datatype IRI.
     *
     * @return Object of appropriate type. If $datatypeUri is given, the object
     * type is decided based on it, otherwise it is based on the PHP type
     * or class of $value.
     */
    public function create($value, $datatypeUri = null): LiteralInterface;

    /// Convert the value to the appropriate PHP type
    public function convertValue($value, $datatypeUri);
}

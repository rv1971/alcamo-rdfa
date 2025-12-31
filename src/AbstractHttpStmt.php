<?php

namespace alcamo\rdfa;

/**
 * @brief Base class of HTTP-related RDFa statement classes
 *
 * @attention Each derived class *must* redefine the class constants
 * - PROP_LOCAL_NAME
 * - PROP_URI (as `self::PROP_NS_NAME . self::PROP_LOCAL_NAME`)
 * - PROP_CURIE (as `self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME`)
 *
 * @date Last reviewed 2025-10-19
 */
abstract class AbstractHttpStmt implements StmtInterface
{
    use FixedPropertyTrait;

    public const HTTP_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:http#';

    /// Namespace name of the property
    public const PROP_NS_NAME = self::HTTP_NS;

    /// Canonical prefix for the property's namespace
    public const PROP_NS_PREFIX = 'http';
}

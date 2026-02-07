<?php

namespace alcamo\rdfa;

/**
 * @brief Base class of OWL RDFa statement classes
 *
 * @attention Each derived class *must* redefine the class constants
 * - PROP_LOCAL_NAME
 * - PROP_URI (as `self::PROP_NS_NAME . self::PROP_LOCAL_NAME`)
 * - PROP_CURIE (as `self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME`)
 *
 * @date Last reviewed 2025-10-19
 */
abstract class AbstractOwlStmt implements StmtInterface
{
    use FixedPropertyTrait;

    public const PROP_NS_NAME = self::OWL_NS;

    public const PROP_NS_PREFIX = self::NS_URI_TO_NS_PREFIX[self::PROP_NS_NAME];
}

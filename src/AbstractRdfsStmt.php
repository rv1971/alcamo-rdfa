<?php

namespace alcamo\rdfa;

use alcamo\xml\NamespaceMapsInterface;

/**
 * @brief Base class of RDFS RDFa statement classes
 *
 * @attention Each derived class *must* redefine the class constants
 * - PROP_LOCAL_NAME
 * - PROP_URI (as `self::PROP_NS_NAME . self::PROP_LOCAL_NAME`)
 * - PROP_CURIE (as `self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME`)
 *
 * @date Last reviewed 2026-02-05
 */
abstract class AbstractRdfsStmt implements StmtInterface
{
    use FixedPropertyTrait;

    public const PROP_NS_NAME = self::RDFS_NS;

    public const PROP_NS_PREFIX =
        NamespaceMapsInterface::NS_NAME_TO_NS_PREFIX[self::PROP_NS_NAME];
}

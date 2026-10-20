<?php

namespace alcamo\rdfa;

use alcamo\xml\NamespaceMapsInterface;

/**
 * @brief Base class of Dublin core RDFa statement classes
 *
 * @attention Each derived class *must* redefine the class constants
 * - PROP_LOCAL_NAME
 * - PROP_URI (as `self::PROP_NS_NAME . self::PROP_LOCAL_NAME`)
 * - PROP_CURIE (as `self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME`)
 *
 * @date Last reviewed 2026-10-20
 */
abstract class AbstractExifStmt implements StmtInterface
{
    use FixedPropertyTrait;

    public const PROP_NS_NAME = self::EXIF_NS;

    public const PROP_NS_PREFIX =
        NamespaceMapsInterface::NS_NAME_TO_NS_PREFIX[self::PROP_NS_NAME];
}

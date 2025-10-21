<?php

namespace alcamo\rdfa;

/**
 * @brief Property data configured by class constants
 *
 * @attention Each class using this trait *must* define the class constants
 * - PROP_NS_NAME
 * - PROP_NS_PREFIX
 * - PROP_LOCAL_NAME
 * - PROP_URI (as `self::PROP_NS_NAME . self::PROP_LOCAL_NAME`)
 * - PROP_CURIE (as `self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME`)
 * In addition, it *may* define a class constant `IS_ONCE_ONLY` to indicate
 * that this property can appear only once .
 *
 * @date Last reviewed 2025-10-19
 */
trait FixedPropertyTrait
{
    use FixedNsTrait;

    /// @copydoc StmtInterface::getPropLocalName()
    public function getPropLocalName(): string
    {
        return static::PROP_LOCAL_NAME;
    }

    /// @copydoc StmtInterface::getPropUri()
    public function getPropUri(): string
    {
        return static::PROP_URI;
    }

    /// @copydoc StmtInterface::getPropCurie()
    public function getPropCurie(): string
    {
        return static::PROP_CURIE;
    }

    /// @copydoc StmtInterface::isOnceOnly()
    public function isOnceOnly(): bool
    {
        return defined('static::IS_ONCE_ONLY') && static::IS_ONCE_ONLY;
    }
}

<?php

namespace alcamo\rdfa;

/**
 * @brief Namespace data configured by class constants
 *
 * @attention Each class using this trait *must* define the class constants
 * - PROP_NS_NAME
 * - PROP_NS_PREFIX
 *
 * @date Last reviewed 2025-10-19
 */
trait FixedNsTrait
{
    use ObjectTrait;

    /// @copydoc StmtInterface::getPropNsName()
    public function getPropNsName(): string
    {
        return static::PROP_NS_NAME;
    }

    /// @copydoc StmtInterface::getPropNsPrefix()
    public function getPropNsPrefix(): string
    {
        return static::PROP_NS_PREFIX;
    }
}

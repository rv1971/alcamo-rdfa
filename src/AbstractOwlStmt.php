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

    public const OWL_NS = 'http://www.w3.org/2002/07/owl#';

    /// Namespace name of the property
    public const PROP_NS_NAME = self::OWL_NS;

    /// Canonical prefix for the property's namespace
    public const PROP_NS_PREFIX = 'owl';
}

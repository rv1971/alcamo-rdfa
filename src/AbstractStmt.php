<?php

namespace alcamo\rdfa;

/**
 * @brief Base class of RDFa statement classes ruled by class constants
 *
 * @attention Each derived class *must* redefine the class constants
 * - PROP_NS_NAME
 * - PROP_NS_PREFIX
 * - PROP_LOCAL_NAME
 * - PROP_URI (as `self::PROP_NS_NAME . self::PROP_LOCAL_NAME`)
 * - PROP_CURIE (as `self::PROP_NS_PREFIX . ':' . self::PROP_LOCAL_NAME`)
 * Furthermore, a derived class *may* redefine the class constant `UNIQUE` as
 * `true` to indicate that this property may have one value only.
 *
 * @date Last reviewed 2025-10-15
 */
abstract class AbstractStmt implements StmtInterface
{
    public const DC_NS = 'http://purl.org/dc/terms/';

    public const OWL_NS = 'http://www.w3.org/2002/07/owl#';

    public const HTTP_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:http#';

    public const META_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:meta#';

    public const REL_NS  = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:rel#';

    /// Namespace name of the property
    public const PROP_NS_NAME = null;

    /// Canonical prefix for the property's namespace
    public const PROP_NS_PREFIX = null;

    /// Local name of the property
    public const PROP_LOCAL_NAME = null;

    /// Property as a URI
    public const PROP_URI = null;

    /// Property as a CURIE using the canonical prefix
    public const PROP_CURIE = null;

    /// Whether a subject may have only one value for the given property
    public const UNIQUE = false;

    private $object_;     ///< any type

    /**
     * @param $object Object of the RDFa statement.
     */
    public function __construct($object)
    {
        $this->object_ = $object;
    }

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

    /// @copydoc StmtInterface::getObject()
    public function getObject()
    {
        return $this->object_;
    }

    /// @copydoc StmtInterface::__toString()
    public function __toString(): string
    {
        return (string)$this->object_;
    }
}

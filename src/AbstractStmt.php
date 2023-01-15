<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement where property is a class constant
 *
 * @attention Each derived class *must* define the class constants
 * - PROP_NS_NAME
 * - PROP_NS_PREFIX
 * - PROP_LOCAL_NAME
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

    private $object_;     ///< any type
    private $isNodeUri_; ///< bool

    /**
     * @param $object Object of the RDFa statement.
     *
     * @param $isNodeUri whether the object is the URI of a resource
     */
    public function __construct($object, bool $isNodeUri)
    {
        $this->object_ = $object;
        $this->isNodeUri_ = $isNodeUri;
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

    /// @copydoc StmtInterface::isNodeUri()
    public function isNodeUri(): bool
    {
        return (bool)$this->isNodeUri_;
    }

    /// @copydoc StmtInterface::__toString()
    public function __toString(): string
    {
        return (string)$this->object_;
    }
}

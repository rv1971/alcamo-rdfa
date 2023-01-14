<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement where property is a class constant
 *
 * @attention Each derived class *must* define the class constants
 * PROP_URI and CANONICAL_PROP_CURIE.
 */
abstract class AbstractStmt implements StmtInterface
{
    public const DS_NS = 'http://purl.org/dc/terms/';

    public const OWL_NS = 'http://www.w3.org/2002/07/owl#';

    public const HTTP_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:http#';

    public const META_NS = 'tag:rv1971@web.de,2021:alcamo-rdfa:ns:meta#';

    /// Property as a URI
    public const PROP_URI = null;

    /// Property as a CURIE using the canonical prefix
    public const CANONICAL_PROP_CURIE = null;

    private $object_;     ///< any type
    private $isResource_; ///< bool

    /**
     * @copydoc StmtInterface::getObjectClass()
     */
    public static function getObjectClass(): ?string
    {
        return null;
    }

    /**
     * @param $object Object of the RDFa statement.
     *
     * @param $isResource whether the object is the URI of a resource
     */
    public function __construct($object, bool $isResource)
    {
        $this->object_ = $object;
        $this->isResource_ = $isResource;
    }

    /// @copydoc StmtInterface::getPropertyUri()
    public function getPropertyUri(): string
    {
        return static::PROPERTY_URI;
    }

    /// @copydoc StmtInterface::getPropertyCurie()
    public function getCanonicalPropertyCurie(): string
    {
        return static::CANONICAL_PROPERTY_CURIE;
    }

    /// @copydoc StmtInterface::getObject()
    public function getObject()
    {
        return $this->object_;
    }

    /// @copydoc StmtInterface::isResource()
    public function isResource(): bool
    {
        return (bool)$this->isResource_;
    }

    /// @copydoc StmtInterface::__toString()
    public function __toString(): string
    {
        return (string)$this->getObject();
    }
}

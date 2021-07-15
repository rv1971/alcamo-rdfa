<?php

namespace alcamo\rdfa;

use alcamo\html_creation\element\{A, Link, Meta, Span};
use alcamo\xml_creation\Nodes;

/**
 * @brief RDFa statement where property is a class constant
 *
 * @attention Each derived class must define a class constant PROPERTY_CURIE
 * and ensure that the CURIE's prefix is found in @ref PREFIX_MAP defined or
 * inherited in the class.
 *
 * A derived class may define class constants as follows:
 * - HTTP_HEADER will be used in toHttpHeaders()
 * - LINK_REL will be used as an additional `rel` value in toHtmlAttrs()
 * - META_NAME will be used as the `name` attribute in toHtmlAttrs()
 * - OBJECT_CLASS which will be returned by getObjectClass()
 *
 * @date Last reviewed 2021-06-18
 */
abstract class AbstractStmt implements StmtInterface
{
    /// Prefix map for property CURIEs
    public const PREFIX_MAP = [
        'dc'  => 'http://purl.org/dc/terms/',
        'owl' => 'http://www.w3.org/2002/07/owl#',
        'header' => 'tag:https://github.com/rv1971/alcamo-rdfa,2021:ns:header#',
        'meta' => 'tag:https://github.com/rv1971/alcamo-rdfa,2021:ns:meta#',
        'rel' => 'tag:https://github.com/rv1971/alcamo-rdfa,2021:ns:rel#'
    ];

    /// Default label returned by getResourceLabel()
    public const RESOURCE_LABEL = null;

    /// Header name for use in toHttpHeaders()
    public const HTTP_HEADER = null;

    /// Value for the `rel` HTML attribute in links
    public const LINK_REL = null;

    /// Value for the `name` HTML attribute in \<meta> elements
    public const META_NAME = null;

    /// Object class returned by getObjectClass()
    public const OBJECT_CLASS = null;

    private $object_; ///< any type

    private $resourceInfo_; ///< see $resourceInfo parameter of __construct()

    /**
     * @copydoc StmtInterface::getObjectClass()
     *
     * @warning The default constructor does not enforce that an object is of
     * this class. This is rather a hint tro Factory::createFromClassName()
     * that a valkue must be converted to this type before feeding it to a
     * constructor. Derived classes should provide constructors that enforce
     * the correct types on their value parameter.
     */
    public static function getObjectClass(): ?string
    {
        return static::OBJECT_CLASS;
    }

    /**
     * @param $object Object of the RDFa statement.
     *
     * @param $resourceInfo Indicates whether the object is a resource and
     * potentially its label
     * - if `false`: object is not a resource
     * - if `true`: object is a resource without label
     * - else: label of the object resource, any type convertible to string
     */
    public function __construct($object, $resourceInfo)
    {
        $this->object_ = $object;
        $this->resourceInfo_ = $resourceInfo;
    }

    /// @copydoc StmtInterface::getPropertyCurie()
    public function getPropertyCurie(): string
    {
        return static::PROPERTY_CURIE;
    }

    /// @copydoc StmtInterface::getPropertyUri()
    public function getPropertyUri()
    {
        [ $prefix, $reference ] = explode(':', static::PROPERTY_CURIE, 2);

        return static::PREFIX_MAP[$prefix] . $reference;
    }

    /// @copydoc StmtInterface::getPrefixMap()
    public function getPrefixMap(): array
    {
        $prefix = explode(':', static::PROPERTY_CURIE, 2)[0];

        return [ $prefix => static::PREFIX_MAP[$prefix] ];
    }

    /// @copydoc StmtInterface::getObject()
    public function getObject()
    {
        return $this->object_;
    }

    /// @copydoc StmtInterface::isResource()
    public function isResource(): bool
    {
        return (bool)$this->resourceInfo_;
    }

    /// @copydoc StmtInterface::getResourceLabel()
    public function getResourceLabel(): ?string
    {
        /** If $resourceInfo given to the constructor is
         * - `false`: return `null`
         * - `true`: return RESOURCE_LABEL (which may be `null`)
         * - anything else: return $resourceInfo converted to string. */

        switch (true) {
            case $this->resourceInfo_ === false:
                return null;

            case $this->resourceInfo_ === true:
                return static::RESOURCE_LABEL;

            default:
                return $this->resourceInfo_;
        }
    }

    /// @copydoc StmtInterface::__toString()
    public function __toString()
    {
        return (string)$this->getObject();
    }

    /// @copydoc StmtInterface::toXmlAttrs()
    public function toXmlAttrs(): ?array
    {
        return [
            'property'
            => static::PROPERTY_CURIE,
            ($this->resourceInfo_ ? 'resource' : 'content')
            => (string)$this
        ];
    }

    /// @copydoc StmtInterface::toHtmlAttrs()
    public function toHtmlAttrs(): ?array
    {
        if ($this->resourceInfo_) {
            // do not include proprietary rel values into HTML code
            if (substr($this->getPropertyUri(), 0, 4) == 'tag:') {
                $rel = static::LINK_REL;
            } else {
                $rel = static::PROPERTY_CURIE;

                if (static::LINK_REL !== null) {
                    $rel .= ' ' . static::LINK_REL;
                }
            }

            return [ 'rel' => $rel, 'href' => (string)$this ];
        } else {
            $attrs = [
                'property' => static::PROPERTY_CURIE,
                'content' => (string)$this
            ];

            if (static::META_NAME !== null) {
                $attrs['name'] = static::META_NAME;
            }
        }

        return $attrs;
    }

    /// @copydoc StmtInterface::toHtmlNodes()
    public function toHtmlNodes(): ?Nodes
    {
        return new Nodes(
            $this->resourceInfo_
            ? new Link(null, $this->toHtmlAttrs())
            : new Meta($this->toHtmlAttrs())
        );
    }

    /**
     * @brief Representation as visible HTML nodes
     *
     * @brief $includeRdfaAttrs Whether to include RDFa attributes. This makes
     * sense if the RDFa data is not contained in the header, in particular if
     * the subject of the RDFa statement is not the entire HTML page but a
     * part of it.
     *
     * While toHtmlNodes() generates HTML code for use in the header, this
     * method generates HTML code for use in the body.
     */
    public function toVisibleHtmlNodes(?bool $includeRdfaAttrs = null): ?Nodes
    {
        if ($this->resourceInfo_) {
            return new Nodes(
                new A(
                    ($this->resourceInfo_ === true
                     ? ($this->getResourceLabel() ?? (string)$this)
                     : $this->resourceInfo_),
                    ($includeRdfaAttrs
                     ? $this->toHtmlAttrs()
                     : [ 'href' => (string)$this ])
                )
            );
        } else {
            return new Nodes(
                $includeRdfaAttrs
                ? new Span(
                    (string)$this,
                    [ 'property' => static::PROPERTY_CURIE ]
                )
                : (string)$this
            );
        }
    }

    /// @copydoc StmtInterface::toHttpHeaders()
    public function toHttpHeaders(): ?array
    {
        return static::HTTP_HEADER !== null
            ? [ static::HTTP_HEADER => [ (string)$this ] ]
            : null;
    }
}

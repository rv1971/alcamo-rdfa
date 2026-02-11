<?php

namespace alcamo\rdfa;

use alcamo\uri\Uri;
use Psr\Http\Message\UriInterface;

/**
 * @brief RDF literal
 *
 * @attention Cloning is shallow, hence $value_ (if it is an object) is cloned
 * by reference. Applications should not modify the result of getValue(),
 * unless it is desired that the modification applies to all literals that
 * reference it.
 *
 * @date Last reviewed 2026-02-05
 */
abstract class AbstractLiteral implements LiteralInterface
{
    /// Must be defined in derived classes
    public const DATATYPE_URI = null;

    /// Return static::DATATYPE_URI as an Uri object
    public static function getClassDatatypeUri(): UriInterface
    {
        static $uris = [];

        return $uris[static::class]
        ?? ($uris[static::class] = new Uri(static::DATATYPE_URI));
    }

    protected $value_;
    protected $datatypeUri_; ///< UriInterface

    /**
     * @param $value in any appropriate PHP type.
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:string`]
     */
    public function __construct($value, $datatypeUri = null)
    {
        /* Unwrap values wrapped into another literal class. This happens, for
         * instance, when OwlVersionInfo gets a LangStringLiteral (from an XML
         * attribute in a place where a language is defined). */
        $this->value_ =
            $value instanceof LiteralInterface ? $value->getValue() : $value;

        $this->datatypeUri_ = isset($datatypeUri)
            ? ($datatypeUri instanceof UriInterface
               ? $datatypeUri
               : new Uri($datatypeUri))
            : static::getClassDatatypeUri();
    }

    public function getValue()
    {
        return $this->value_;
    }

    public function getDatatypeUri(): UriInterface
    {
        return $this->datatypeUri_;
    }

    /** @return Always `null`. */
    public function getLang(): ?Lang
    {
        return null;
    }

    public function __toString(): string
    {
        return $this->value_;
    }

    public function getDigest(): string
    {
        return $this;
    }
}

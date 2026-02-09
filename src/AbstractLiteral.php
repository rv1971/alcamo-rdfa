<?php

namespace alcamo\rdfa;

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

    protected $value_;
    protected $datatypeUri_; ///< string or stringable URI

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

        $this->datatypeUri_ = $datatypeUri ?? static::DATATYPE_URI;
    }

    public function getValue()
    {
        return $this->value_;
    }

    public function getDatatypeUri()
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

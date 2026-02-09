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
class Literal implements LiteralInterface
{
    public const DATATYPE_URI = self::XSD_NS_NAME . 'string';

    protected $value_;
    protected $datatypeUri_; ///< string or stringable URI

    /**
     * @param $value in any appropriate PHP type.
     *
     * @param $datatypeUri Datatype IRI. [Default `xsd:string`]
     */
    public function __construct($value, $datatypeUri = null)
    {
        $this->value_ = $value;
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

<?php

namespace alcamo\rdfa;

/**
 * @brief Language tag as defined in RFC4646
 *
 * @sa [RFC4646](http://tools.ietf.org/html/rfc4646).
 *
 * @invariant Immutable class.
 */
class Lang
{
    private $subtags_;

    public static function newFromPrimary(string $primary): self
    {
        return new self([ 'language' => $primary ]);
    }

    public static function newFromPrimaryAndRegion(
        string $primary,
        string $region
    ): self {
        return new self([ 'language' => $primary, 'region' => $region ]);
    }

    public static function newFromString(string $lang): self
    {
        return new self(\Locale::parseLocale($lang));
    }

    public static function newFromDefaultLocale(): self
    {
        return new self(\Locale::parseLocale(\Locale::getDefault()));
    }

    private function __construct($subtags)
    {
        $this->subtags_ = $subtags;
    }

    /// Representation using hyphens
    public function __toString(): string
    {
        return strtr(\Locale::composeLocale($this->subtags_), '_', '-');
    }

    /// Subtags as returned by Locale::parseLocale()
    public function getSubtags(): array
    {
        return $this->subtags_;
    }

    /// Primary language subtag
    public function getPrimary(): string
    {
        return $this->subtags_['language'];
    }

    /// Region subtag
    public function getRegion(): string
    {
        return $this->subtags_['region'];
    }
}

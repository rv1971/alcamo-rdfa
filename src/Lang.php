<?php

namespace alcamo\rdfa;

/**
 * @brief Language tag as defined in RFC4646
 *
 * @sa [RFC4646](http://tools.ietf.org/html/rfc4646).
 *
 * @invariant Immutable class.
 *
 * @date Last reviewed 2025-10-16
 *
 * @date Last reviewed 2025-10-16
 */
class Lang
{
    private $subtags_; ///< array

    public static function newFromPrimary(string $primary): self
    {
        return new self([ 'language' => $primary ]);
    }

    public static function newFromPrimaryAndRegion(
        string $primary,
        ?string $region
    ): self {
        return new self(
            isset($region)
                ? [ 'language' => $primary, 'region' => $region ]
                : [ 'language' => $primary ]
        );
    }

    /**  @return `null` if $lang is the empty string, conforming to
     * [Language Identification](https://www.w3.org/TR/xml/#sec-lang-tag)
     * in XML documents. */
    public static function newFromString(string $lang): ?self
    {
        return $lang != '' ? new self(\Locale::parseLocale($lang)) : null;
    }

    public static function newFromCurrentLocale(): self
    {
        return new self(\Locale::parseLocale(setlocale(LC_ALL, 0)));
    }

    private function __construct(array $subtags)
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
    public function getRegion(): ?string
    {
        return $this->subtags_['region'] ?? null;
    }
}

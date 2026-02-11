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

    /**
     * @brief Count common subtags
     *
     * This is useful to identify the best match for a desired language tag in
     * a list of given language tags.
     *
     * @param Lang|string|`null` $lang Language tag to compare with.
     *
     * @return
     * - If $lang is not `null` and not the empty string and there are no common
     * subtags, return -1.
     * - If $lang is `null` or the empty string, return 0.
     * - Otherwise, return the number of common subtags. Subtags are compare
     * left to right. If two subtags are equal, they are counted as 1. If one
     * subtag is specified and the other one is unspecified, they are ignored,
     * and comparison continues. If both are specified and different,
     * comparison stops.
     */
    public function countCommonSubtags($lang = null): int
    {
        if (!isset($lang) || $lang == '') {
            return 0;
        }

        if (!($lang instanceof Lang)) {
            $lang = Lang::newFromString($lang);
        }

        $subtags1 = $this->subtags_;
        $subtags2 = $lang->subtags_;

        if ($subtags1['language'] != $subtags2['language']) {
            return -1;
        }

        $common = 1;

        unset($subtags1['language']);
        unset($subtags2['language']);

        foreach ($subtags1 as $subtag => $value) {
            if (!isset($subtags2[$subtag])) {
                continue;
            }

            if (strtolower($subtags2[$subtag]) != strtolower($value)) {
                break;
            }

            $common++;
        }

        return $common;
    }
}

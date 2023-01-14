<?php

namespace alcamo\rdfa;

/**
 * @namespace alcamo::rdfa
 *
 * @brief Classes to store RDFa statements
 */

/**
 * @brief RDFa statement
 *
 * @sa [RDFa Primer](https://www.w3.org/TR/rdfa-primer/)
 *
 * @sa [CURIE Syntax](https://www.w3.org/TR/curie/)
 *
 * @date Last reviewed 2021-06-18
 */
interface StmtInterface
{
    /// Class the object must have, or null if there is no constraint
    public static function getObjectClass(): ?string;

    /// Property as a URI
    public function getPropertyUri(): string;

    /// Property as a CURIE using the canonical prefix
    public function getCanonicalPropertyCurie(): string;

    /// Object of the RDFa statement
    public function getObject();

    /// Whether the object is the URI of a resource
    public function isResource(): bool;

    /// String representation of the object
    public function __toString(): string;
}

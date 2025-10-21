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
 * @date Last reviewed 2025-10-15
 */
interface StmtInterface
{
    /// Namespace name of the property
    public function getPropNsName(): string;

    /// Canonical prefix for the property's namespace
    public function getPropNsPrefix(): string;

    /// Local name of the property
    public function getPropLocalName(): string;

    /// Property as a URI
    public function getPropUri(): string;

    /// Property as a CURIE using the canonical prefix
    public function getPropCurie(): string;

    /// Whether this property can appear only once
    public function isOnceOnly(): bool;

    /// Object of the RDFa statement
    public function getObject();

    /// String representation of the object
    public function __toString(): string;
}

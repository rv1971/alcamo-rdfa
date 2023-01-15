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

    /// Property as a CURIE using a canonical prefix
    public function getPropCurie(): string;

    /// Object of the RDFa statement
    public function getObject();

    /// Whether the object is the URI of a node rather than a literal content
    public function isNodeUri(): bool;

    /// String representation of the object
    public function __toString(): string;
}

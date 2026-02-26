<?php

namespace alcamo\rdfa;

use Psr\Http\Message\UriInterface;

/**
 * @brief RDF literal
 *
 * @sa [RDF Literals](https://www.w3.org/TR/2014/REC-rdf11-concepts-20140225/#section-Graph-Literal)
 *
 * @invariant Implementations should be immutable.
 *
 * @date Last reviewed 2026-02-05
 */
interface LiteralInterface extends HavingDigestInterface, LiteralOrNodeInterface
{
    public const RDF_NS = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';
    public const XSD_NS = 'http://www.w3.org/2001/XMLSchema#';

    /// Namespace for additional datatypes defined in this package
    public const ALCAMO_NS = 'tag:rv1971@web.de,2021:alcamo:ns:base#';

    /// Value as an appropriate PHP type, not necessarily stringable
    public function getValue();

    public function getDatatypeUri(): UriInterface;

    /// Language, if available
    public function getLang(): ?Lang;

    /// String representation of value
    public function __toString(): string;

    /**
     * @brief Whether $this and $literal are considered equal
     *
     * This is the case if:
     * - both PHP classes have the same PRIMITIVE_DATATYPE_URI
     * - AND the values are equal.
     *
     * Indeed, [XML Schema Part 2](https://www.w3.org/TR/xmlschema-2/#equal)
     * states that *the value spaces of all primitive datatypes are
     * disjoint*. Hence the underlying primitive datatype makes a difference
     * while the actual dtatatype does not.
     */
    public function equals(self $literal): bool;
}

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
    public const RDF_NS_NAME = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

    public const XH_NS = 'http://www.w3.org/1999/xhtml';

    public const XSD_NS_NAME = 'http://www.w3.org/2001/XMLSchema#';

    /// Value as an appropriate PHP type, not necessarily stringable
    public function getValue();

    public function getDatatypeUri(): UriInterface;

    /// Language, if available
    public function getLang(): ?Lang;

    /// String representation of value
    public function __toString(): string;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief RDF literal
 *
 * @sa [RDF Literals](https://www.w3.org/TR/2014/REC-rdf11-concepts-20140225/#section-Graph-Literal)
 *
 * @date Last reviewed 2026-02-05
 */
interface LiteralInterface
{
    public const RDF_NS_URI = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

    public const XSD_NS_URI = 'http://www.w3.org/2001/XMLSchema#';

    /// Value as an appropriate PHP type, not necessarily stringable
    public function getValue();

    /// string or stringable URI
    public function getDatatypeUri();

    /// Language, if available
    public function getLang(): ?Lang;

    /// String representation of value
    public function __toString(): string;

    /// Forward calls to value
    public function __call(string $name, array $params);
}

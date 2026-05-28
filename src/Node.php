<?php

namespace alcamo\rdfa;

use alcamo\rdf_literal\{Lang, LiteralOrNodeInterface};
use alcamo\uri\Uri;
use Psr\Http\Message\UriInterface;

/**
 * @brief RDFa node
 *
 * @invariant Immutable object.
 *
 * @date Last reviewed 2025-10-18
 */
class Node implements HavingRdfaDataInterface, LiteralOrNodeInterface
{
    private $uri_;      ///< UriInterface
    private $rdfaData_; ///< ?RdfaData

    /**
     * @param $uri Resource URI.
     *
     * @param RdfaData|array RDFa data about the resource
     */
    public function __construct($uri, $rdfaData = null)
    {
        $this->uri_ = $uri instanceof UriInterface ? $uri : new Uri($uri);

        $this->rdfaData_ = ImmutableRdfaData::newFromData($rdfaData);
    }

    public function getUri(): UriInterface
    {
        return $this->uri_;
    }

    public function getRdfaData(): ?AbstractRdfaData
    {
        return $this->rdfaData_;
    }

    public function __toString(): string
    {
        return $this->uri_;
    }

    /// Content of first dc:language in RdfaData, if any
    public function getLang(): ?Lang
    {
        $dcLanguage = $this->getRdfaData()['dc:language'] ?? null;

        return isset($dcLanguage)
            ? $dcLanguage->first()->getObject()->getValue()
            : null;
    }
}

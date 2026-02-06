<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa node
 *
 * @date Last reviewed 2025-10-18
 */
class Node
{
    private $uri_;      ///< string or convertible to string
    private $rdfaData_; ///< ?RdfaData

    /**
     * @param $uri Resource URI.
     *
     * @param RdfaData|array RDFa data about the resource
     */
    public function __construct($uri, $rdfaData = null)
    {
        $this->uri_ = $uri;

        if (isset($rdfaData)) {
            $this->rdfaData_ = $rdfaData instanceof RdfaData
                ? $rdfaData
                : RdfaData::newFromIterable($rdfaData);
        }
    }

    public function getUri()
    {
        return $this->uri_;
    }

    public function getRdfaData(): ?RdfaData
    {
        return $this->rdfaData_;
    }

    public function __toString(): string
    {
        return $this->uri_;
    }
}

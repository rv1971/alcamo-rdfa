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

    public function __construct($uri, ?RdfaData $rdfaData = null)
    {
        $this->uri_ = $uri;
        $this->rdfaData_ = $rdfaData;
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

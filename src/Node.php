<?php

namespace alcamo\rdfa;

/// RDFa node
class Node
{
    private $uri_;       ///< string
    private $rdfaData_; ///< ?RdfaData

    public function __construct(string $uri, ?RdfaData $rdfaData = null)
    {
        $this->uri_ = $uri;

        $this->rdfaData_ = $rdfaData;
    }

    public function getUri(): string
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

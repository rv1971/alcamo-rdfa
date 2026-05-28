<?php

namespace alcamo\rdfa;

use Ds\Set;

/**
 * @brief Mutable collection of RDFa statements
 *
 * @date Last reviewed 2026-02-12
 */
class RdfaData extends AbstractRdfaData
{
    private $propUrisToDelete_; ///< Set

    protected function __construct(
        ?array $rdfaData = null,
        ?array $curieToUri = null
    ) {
        parent::__construct($rdfaData, $curieToUri);

        $this->propUrisToDelete_ = new Set();
    }

    public function __clone()
    {
        $rdfaData = [];

        foreach ($this->data_ as $key => $stmts) {
            $rdfaData[$key] = clone $stmts;
        }

        $this->data_ = $rdfaData;

        $this->propUrisToDelete_ = clone $this->propUrisToDelete_;
    }

    /**
     * The properties with URIs in this set are deleted from an RdfData object
     * when the present object is used as an argument for replace().
     */
    public function getPropUrisToDelete(): Set
    {
        return $this->propUrisToDelete_;
    }

    public function toImmutable(): ImmutableRdfaData
    {
        $immutable = ImmutableRdfaData::newEmpty();

        $immutable->data_ = [];

        foreach ($this->data_ as $key => $stmts) {
            $immutable->data_[$key] = $stmts->toImmutable();
        }

        $immutable->curieToUri_ = $this->curieToUri_;

        return $immutable;
    }

    /// Unset all data for a property URI or CURIE
    public function offsetUnset($offset): void
    {
        $offset = (string)$offset;

        $uri = isset($this->data_[$offset])
            ? $offset
            : ($this->curieToUri_[$offset] ?? null);

        if (isset($uri) && isset($this->data_[$uri])) {
            unset($this->data_[$uri]);

            foreach ($this->curieToUri_ as $curie => $uri2) {
                if ($uri2 == $uri) {
                    unset($this->curieToUri_[$curie]);

                    break;
                }
            }
        }
    }

    /**
     * @brief Add a statement
     *
     * @return $this
     */
    public function addStmt(StmtInterface $stmt): self
    {
        $uri = $stmt->getPropUri();

        if (!isset($this->data_[$uri])) {
            $this->data_[$uri] = new StmtCollection();

            $curie = $stmt->getPropCurie();

            if (isset($curie)) {
                $this->curieToUri_[$curie] = $uri;
            }
        }

        $this->data_[$uri]->addStmt($stmt);

        return $this;
    }

    /**
     * @brief Add properties without overwriting existing ones
     *
     * @return $this
     */
    public function add(AbstractRdfaData $rdfaData): self
    {
        foreach ($rdfaData->data_ as $uri => $stmts) {
            if (isset($this->data_[$uri])) {
                $this->data_[$uri]->addStmtCollection($stmts);
            } else {
                $this->data_[$uri] = clone $stmts;
            }

            $this->propUrisToDelete_->remove($uri);
        }

        $this->curieToUri_ += $rdfaData->curieToUri_;

        if ($rdfaData instanceof self) {
            $this->propUrisToDelete_ =
                $this->propUrisToDelete_->union($rdfaData->propUrisToDelete_);
        }

        return $this;
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace(AbstractRdfaData $rdfaData): self
    {
        $this->data_ = $rdfaData->data_ + $this->data_;

        $this->curieToUri_ = $rdfaData->curieToUri_ + $this->curieToUri_;

        if ($rdfaData instanceof self) {
            foreach ($rdfaData->propUrisToDelete_ as $uri) {
                $this->offsetUnset($uri);
            }
        }

        foreach ($rdfaData->data_ as $uri => $stmts) {
            $this->propUrisToDelete_->remove($uri);
        }

        return $this;
    }
}

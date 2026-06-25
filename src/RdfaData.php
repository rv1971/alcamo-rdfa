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
    /**
     * @brief Create from array of RDFa data or RDFa data object or null
     *
     * @param RdfaData|ImmutableRdfaData|array|null If array, see
     * alcamo::rdfa_data::AbstractRdfaData::newFromIterable().
     *
     * @param $rdfaFactory See
     * alcamo::rdfa_data::AbstractRdfaData::newFromIterable().
     *
     * @param $flags See
     * alcamo::rdfa_data::AbstractRdfaData::newFromIterable().
     */
    public static function newFromData(
        $rdfaData,
        ?RdfaFactoryInterface $rdfaFactory = null,
        ?int $flags = null
    ): self {
        switch (true) {
            case $rdfaData instanceof RdfaData:
                return clone $rdfaData;

            case $rdfaData instanceof ImmutableRdfaData:
                return $rdfaData->toMutable();

            case !$rdfaData:
                return self::newEmpty();

            default:
                return self::newFromIterable($rdfaData, $rdfaFactory, $flags);
        }
    }

    public function __clone()
    {
        parent::__clone();

        $rdfaData = [];

        foreach ($this->data_ as $key => $stmts) {
            $rdfaData[$key] = clone $stmts;
        }

        $this->data_ = $rdfaData;
    }

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

        $immutable->propUrisToDelete_ = clone $this->propUrisToDelete_;

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
    public function add($rdfaData): self
    {
        if (!($rdfaData instanceof self)) {
            $rdfaData = static::newFromData($rdfaData);
        }

        foreach ($rdfaData->data_ as $uri => $stmts) {
            if (isset($this->data_[$uri])) {
                $this->data_[$uri]->addStmtCollection($stmts);
            } else {
                $this->data_[$uri] = $stmts instanceof StmtCollection
                    ? clone $stmts
                    : $stmts->toMutable();
            }

            $this->propUrisToDelete_->remove($uri);
        }

        $this->curieToUri_ += $rdfaData->curieToUri_;

        $this->propUrisToDelete_ =
            $this->propUrisToDelete_->union($rdfaData->propUrisToDelete_);

        return $this;
    }

    /// Return a new object with added properties, overwriting existing ones
    public function replace($rdfaData): self
    {
        if (!($rdfaData instanceof self)) {
            $rdfaData = static::newFromData($rdfaData);
        }

        $this->data_ = $rdfaData->data_ + $this->data_;

        $this->curieToUri_ = $rdfaData->curieToUri_ + $this->curieToUri_;

        foreach ($rdfaData->propUrisToDelete_ as $uri) {
            $this->offsetUnset($uri);
        }

        foreach ($rdfaData->data_ as $uri => $stmts) {
            $this->propUrisToDelete_->remove($uri);
        }

        return $this;
    }
}

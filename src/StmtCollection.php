<?php

namespace alcamo\rdfa;

/**
 * @brief Mutable collection of RDFa statements
 *
 * @date Last reviewed 2026-02-05
 */
class StmtCollection extends AbstractStmtCollection
{
    public function toImmutable(): ImmutableStmtCollection
    {
        $immutable = new ImmutableStmtCollection();

        $immutable->data_ = $this->data_;

        return $immutable;
    }

    /**
     * @brief Add a statement
     */
    public function addStmt(StmtInterface $stmt): self
    {
        $this->internalAddStmt($stmt);

        return $this;
    }

    /**
     * @brief Add statements from a collection, not overwriting existing
     * statements with identical keys
     */
    public function addStmtCollection(
        AbstractStmtCollection $stmtCollection
    ): self {
        $this->data_ += $stmtCollection->data_;

        return $this;
    }
}

<?php

namespace alcamo\rdfa;

/**
 * @brief Immutable collection of RDFa statements
 *
 * @date Last reviewed 2026-05-28
 */
class ImmutableStmtCollection extends AbstractStmtCollection
{
    public function toMutable(): StmtCollection
    {
        $mutable = new StmtCollection();

        $mutable->data_ = $this->data_;

        return $mutable;
    }
}

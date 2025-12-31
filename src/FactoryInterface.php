<?php

namespace alcamo\rdfa;

/// Interface for RDFa data factories
interface FactoryInterface
{
    /**
     * @brief Create an array of statment objects from an array of data pairs
     *
     * Entries with value `nll` in the input are silently discarded.
     *
     * @param $data pairs consisting of a property CURIE and one of
     * - instance of StmtInterface
     * - primitive object
     * - `array`
     * - `null`
     *
     * @return Map of property CURIE to array of instances of StmtInterface,
     *   indexed by string representation of the statement object,
     *   otherwise. The indexing implies that double occurrences of the same
     *   statement are silently discarded.
     *
     * @throw alcamo::exception::DataValidationFailed if the input contains an
     * RDFa statement not matching its key CURIE.
     */
    public function createStmtArrayFromIterable(iterable $map): array;
}

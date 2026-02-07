<?php

namespace alcamo\rdfa;

/**
 * @brief Interface for RDFa data factories
 *
 * @date Last reviewed 2026-02-07
 */
interface RdfaFactoryInterface extends NamespaceConstantsInterface
{
    /**
     * @brief Construct a statement from a property CURIE and object data
     *
     * If $data is an array, construct a Node from it. This allows to
     * distinguish in $data whether a string represents a string value or a
     * Node URI, for those statements where both are possible (such as
     * DcRights). In the latter case, the Node URI must be given as a
     * one-element array.
     */
    public function createStmtFromCurieAndData(
        string $curie,
        $data
    ): StmtInterface;
}

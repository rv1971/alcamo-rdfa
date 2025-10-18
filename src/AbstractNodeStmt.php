<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is a node
 *
 * @date Last reviewed 2025-10-18
 */
abstract class AbstractNodeStmt extends AbstractStmt
{
    public function __construct($nodeOrUri, ?RdfaData $rdfaData = null)
    {
        parent::__construct(
            $nodeOrUri instanceof Node
                ? $nodeOrUri :
                new Node($nodeOrUri, $rdfaData)
        );
    }
}

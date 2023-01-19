<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is a node
 */
abstract class AbstractNodeStmt extends AbstractStmt
{
    public function __construct($node)
    {
        parent::__construct($node instanceof Node ? $node : new Node($node));
    }
}

<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is always a URI of a node
 */
abstract class AbstractNodeUriStmt extends AbstractStmt
{
    public function __construct($uri)
    {
        parent::__construct($uri, true);
    }
}

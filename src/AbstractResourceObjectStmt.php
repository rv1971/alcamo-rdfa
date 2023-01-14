<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is always a resource
 */
abstract class AbstractResourceObjectStmt extends AbstractStmt
{
    public function __construct($uri)
    {
        parent::__construct($uri, true);
    }
}

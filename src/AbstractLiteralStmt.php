<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is always literal content
 */
abstract class AbstractLiteralStmt extends AbstractStmt
{
    public function __construct($content)
    {
        parent::__construct($content, false);
    }
}

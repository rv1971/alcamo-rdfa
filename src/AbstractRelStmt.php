<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement expressing an HTML relation
 */
abstract class AbstractRelStmt extends AbstractNodeUriStmt
{
    public const PROP_NS_NAME = self::REL_NS;

    public const PROP_NS_PREFIX = 'rel';
}

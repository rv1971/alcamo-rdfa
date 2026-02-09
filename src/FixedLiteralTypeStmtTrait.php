<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is a literal of fixed type
 *
 * @attention Each class using this trait *must* define the class constant
 * LITERAL_CLASS.
 *
 * @date Last reviewed 2026-02-05
 */

trait FixedLiteralTypeStmtTrait
{
    public function __construct($object)
    {
        $class = static::LITERAL_CLASS;

        parent::__construct(
            $object instanceof $class ? $object : new $class($object)
        );
    }
}

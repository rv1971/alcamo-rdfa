<?php

namespace alcamo\rdfa;

use alcamo\exception\InvalidEnumerator;

/**
 * @brief RDFa statement whose object is an enumerator
 *
 * @attention Each derived class must define a class constant VALUES which
 * must be an array of legal values.
 */
abstract class AbstractEnumeratorObjectStmt extends AbstractLiteralObjectStmt
{
    public function __construct(string $value)
    {
        if (!in_array($value, static::VALUES)) {
            /** @throw alcamo::exception::InvalidEnumerator if $value is not a
             *  valid enumerator. */
            throw (new InvalidEnumerator())->setMessageContext(
                [
                    'value' => $value,
                    'expectedOneOf' => static::VALUES
                ]
            );
        }

        parent::__construct($value);
    }
}

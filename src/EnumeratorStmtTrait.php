<?php

namespace alcamo\rdfa;

use alcamo\exception\InvalidEnumerator;

/**
 * @brief RDFa statement whose object is an enumerator
 *
 * @attention Each class using this trait *must* define a class constant
 * VALUES which must be an array of legal value strings.
 *
 * @date Last reviewed 2025-10-19
 */
trait EnumeratorStmtTrait
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

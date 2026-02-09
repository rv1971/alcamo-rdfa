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
    public function __construct(string $object)
    {
        if (!in_array($object, static::VALUES)) {
            /** @throw alcamo::exception::InvalidEnumerator if $object is not a
             *  valid enumerator. */
            throw (new InvalidEnumerator())->setMessageContext(
                [
                    'value' => $object,
                    'expectedOneOf' => static::VALUES
                ]
            );
        }

        $class = static::LITERAL_CLASS;

        parent::__construct(
            $object instanceof $class ? $object : new $class($object)
        );
    }
}

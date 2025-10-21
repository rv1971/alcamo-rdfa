<?php

namespace alcamo\rdfa;

/**
 * @brief RDFa statement whose object is a DateTime object
 *
 * @date Last reviewed 2025-10-19
 */
trait DateTimeStmtTrait
{
    public function __construct($timestamp)
    {
        parent::__construct(
            $timestamp instanceof \DateTime
            ? $timestamp
            : new \DateTime($timestamp)
        );
    }

    /// Return content using as ISO 8601 string
    public function __toString(): string
    {
        return $this->format('c');
    }
}

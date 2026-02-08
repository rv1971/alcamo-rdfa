<?php

namespace alcamo\rdfa;

/**
 * @brief Object providing a getDigest() method.
 *
 * @date Last reviewed 2026-02-08
 */
interface HavingDigestInterface
{
    /**
     * @brief Provide a human-readable summary of the object content
     *
     * The return value should be suitable as an array key for that object,
     * i.e. two objects of the same type that are considered different and
     * might appear together in an array should produce different digests.
     *
     * A call of __toString() (if available) may be a suitable implementation
     * in many but not all cases, because the object may have properties which
     * do not influence the string representation but make a relevant
     * difference, such as language tags. Indeed, objects representing
     * "trace"@en and "trace"@fr may be considered different, and a
     * multi-language data structure may need to use both.
     */
    public function getDigest(): string;
}

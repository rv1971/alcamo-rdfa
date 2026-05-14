<?php

namespace alcamo\rdfa;

/**
 * @brief Having a label, potentially language-dependent
 *
 * @date Last reviewed 2026-05-14
 */
interface HavingLabelInterface
{
    /// Fallback to a different language if the requested one is not available
    public const FALLBACK_TO_DIFFERENT_LANG = 1;

    /*
     * @param Lang|string|null $lang desired language.
     *
     * @param $fallbackFlags OR-Combination of the above constants and
     * potentially other constants defined in the classes that implement
     * this interface. Such constants should be greater than 256, to allow for
     * further development of the present interface.
     */
    public function getLabel($lang = null, ?int $fallbackFlags = null): ?string;
}

<?php

namespace alcamo\rdfa;

/**
 * @brief Having RDFa data
 *
 * @date Last reviewed 2026-05-29
 */
interface HavingRdfaDataInterface
{
    public function getRdfaData(): ImmutableRdfaData;
}

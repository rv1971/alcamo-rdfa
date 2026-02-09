<?php

namespace alcamo\rdfa;

/**
 * @brief Having RDFa data
 *
 * @date Last reviewed 2026-02-09
 */
interface HavingRdfaDataInterface
{
    public function getRdfaData(): ?RdfaData;
}
